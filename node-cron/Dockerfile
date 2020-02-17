FROM edbizarro/gitlab-ci-pipeline-php:7.3

WORKDIR /var/www/html
COPY --chown=php:php ./ /var/www/html
WORKDIR /var/www/html/node-cron
RUN npm ci --only=production
CMD [ "node", "src/index.js" ]
