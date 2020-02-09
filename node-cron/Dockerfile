FROM edbizarro/gitlab-ci-pipeline-php:7.3

WORKDIR /var/www/html
COPY --chown=php:php ./ /var/www/html
RUN cd node-cron && npm ci --only=production
CMD [ "node", "node-cron/src/index.js" ]
