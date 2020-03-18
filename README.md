[![Gitter](https://badges.gitter.im/ssorder/community.svg)](https://gitter.im/ssorder/community?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge)
[![Maintainability Rating](https://sonarcloud.io/api/project_badges/measure?project=ssorder&metric=sqale_rating)](https://sonarcloud.io/dashboard?id=ssorder)
# ssorder

A web application created by intern. Currently develop after hours as an opensource project. It is used to order and settle meals for employees. "Sandbox" for introducing new technological solutions.

* integration with Google Analytics Events. Sending information about the occurrence of a selected event, e.g. a new order
* Integration with the Rocket.Chat system (sending notifications to the channel)
* Rocket.Chat bot that responds to user commands (webhooks)
* Integration of the npm symfony/encore package to build css/js with yii2 assets
* Unit tests and e2e tests
* Migrated from PHP 5 to PHP 7
* CI/CD pipeline
* JSON REST API (JWT Token, postman/newman tests)
* Pair programming
* React.js
* Redis Pub/Sub and SSE
* Customised Bootstrap 4
* OpenAPI to describe REST API
* Deploy by Docker

## Setup

You should copy file `.env.dist` to `.env`.
In the new file edit value of `COMPOSER_GITHUB_OAUTH` and `GA_TRACKING_ID`.
If you don't do it `make` will do it for you, but not set `COMPOSER_GITHUB_OAUTH`.
You may get an error with GitHub rate limit.
Run `make setup`. You need a `make` package.
Or run these commands from the target  `setup` manually.
Make sure that nothing listens on port 80, otherwise up traefik will fail.
