.PHONY: setup restore-db install-dependencies


.env:
	cp .env.dist .env

setup: .env
	mkdir -p frontend/runtime/cache
	chmod 777 frontend/runtime/cache
	chmod 777 frontend/runtime
	mkdir -p frontend/web/assets
	chmod 777 frontend/web/assets
	ln -s config-dev.js frontend/webpack/config.js
	docker-compose up -d mongo
	docker-compose run --rm wait -c mongo:27017 -t 15
	docker-compose up -d mongo-init-replica
	docker-compose up -d
	docker-compose run --rm wait -c minio:9000 -t 15
	docker-compose exec cli bash -c "composer install"
	docker-compose exec cli bash -c "cd frontend && yarn install --frozen-lock-file"
	docker-compose exec cli bash -c 'cd frontend && yarn build'
	docker-compose exec cli bash -c "./yii migrate/up --interactive 0"
	docker-compose exec cli bash -c "./yii init/create-bucket"
	docker-compose exec cli bash -c "./yii fixture/load '*' --interactive 0 "
	docker-compose exec cli bash -c "cd provision/rocketchat/ && npm ci"
	docker-compose exec cli bash -c "cd provision/rocketchat/ && node incomingIntegration.js"
	docker-compose exec cli bash -c "cd provision/rocketchat/ && node outgoingIntegration.js"
	ln -s bower-asset vendor/bower

restore-db:
	docker exec -i $(shell docker-compose ps -q mysql) mysql -ussorder -pssorderpassword  -D ssorder < ssorder-backup.sql

hadolint:
	docker run --rm -v $(PWD):/app -it hadolint/hadolint:v1.16.3-debian bash -c "find /app -iname 'Dockerfile*' | grep -v '/app/vendor' | xargs --max-lines=1 hadolint"

install-dependencies:
	docker-compose exec cli bash -c "composer install"
	docker-compose exec cli bash -c "cd api && composer install"
	docker-compose exec cli bash -c "cd frontend/ && yarn"
	docker-compose exec cli bash -c "cd node-cron/ && npm install"

cypress:
	docker run --network=host  --ipc=host --rm -it -v $(PWD)/frontend/e2e:/e2e -w /e2e cypress/included:8.7.0 --env configFile=docker

cypress-debug:
	#npx cypress open --env configFile=docker
	docker run --rm -it \
	  --network=host \
      -v $(PWD)/frontend/e2e:/e2e \
      -v /tmp/.X11-unix:/tmp/.X11-unix \
      -w /e2e \
      -e DISPLAY=:1 \
      --entrypoint cypress \
      cypress/included:8.7.0 open --project .

qa:
	docker run --rm -v $(PWD):/project -w /project jakzal/phpqa:alpine phpstan analyse --no-interaction ./frontend ./common ./console
	docker run --rm -v $(PWD):/project -w /project/api jakzal/phpqa:alpine sh -c 'composer global bin phpstan require --with-all-dependencies symfony/config:^5.4 symfony/dependency-injection:^5.4 symplify/astral:^10.0@dev symplify/composer-json-manipulator:^10.0@dev symplify/phpstan-rules:10.0.0-beta5@dev symplify/package-builder:^10.0@dev symplify/simple-php-doc-parser:^10.0@dev symplify/smart-file-system:^10.0@dev symplify/rule-doc-generator-contracts:^10.0@dev symplify/symplify-kernel:^10.0@dev symplify/easy-testing:^10.0@dev symplify/autowire-array-parameter:^10.0@dev && phpstan'

jmeter:
	mkdir -p docs/jmeter
	docker run --network=host --rm -i -v ${PWD}:/app -w /app justb4/jmeter -Jjmeterengine.force.system.exit=true -n -t /app/performance-tests/performance.jmx -l /app/docs/jmeter/performance.csv -e -o  /app/docs/jmeter/report

update-dependencies:
	docker-compose exec cli bash -c 'cd api && composer update'
	docker-compose exec cli bash -c 'composer update'
	docker-compose exec cli bash -c 'cd frontend/e2e && npm update'
	docker-compose exec cli bash -c 'cd node-cron && npm update'
