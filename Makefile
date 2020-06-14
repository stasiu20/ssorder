.PHONY: setup restore-db


.env:
	cp .env.dist .env

setup: .env
	mkdir -p frontend/runtime/cache
	chmod 777 frontend/runtime/cache
	chmod 777 frontend/runtime
	mkdir -p frontend/web/assets
	chmod 777 frontend/web/assets
	cd frontend/webpack && ln -s config-dev.js config.js
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