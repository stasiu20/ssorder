[![Gitter](https://badges.gitter.im/ssorder/community.svg)](https://gitter.im/ssorder/community?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge)
<!-- ALL-CONTRIBUTORS-BADGE:START - Do not remove or modify this section -->
[![All Contributors](https://img.shields.io/badge/all_contributors-4-orange.svg?style=flat-square)](#contributors-)
<!-- ALL-CONTRIBUTORS-BADGE:END -->
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

## Contributors ✨

Thanks goes to these wonderful people ([emoji key](https://allcontributors.org/docs/en/emoji-key)):

<!-- ALL-CONTRIBUTORS-LIST:START - Do not remove or modify this section -->
<!-- prettier-ignore-start -->
<!-- markdownlint-disable -->
<table>
  <tr>
    <td align="center"><a href="https://github.com/stasiu20"><img src="https://avatars1.githubusercontent.com/u/24654238?v=4" width="80px;" alt=""/><br /><sub><b>stasiu20</b></sub></a><br /><a href="https://github.com/stasiu20/ssorder/commits?author=stasiu20" title="Code">💻</a></td>
    <td align="center"><a href="http://morawskim.pl"><img src="https://avatars1.githubusercontent.com/u/1105278?v=4" width="80px;" alt=""/><br /><sub><b>Marcin Morawski</b></sub></a><br /><a href="https://github.com/stasiu20/ssorder/commits?author=morawskim" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/themalek"><img src="https://avatars0.githubusercontent.com/u/14993588?v=4" width="80px;" alt=""/><br /><sub><b>Tomasz</b></sub></a><br /><a href="https://github.com/stasiu20/ssorder/commits?author=themalek" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/rrudowski"><img src="https://avatars0.githubusercontent.com/u/19334982?v=4" width="80px;" alt=""/><br /><sub><b>rrudowski</b></sub></a><br /><a href="https://github.com/stasiu20/ssorder/issues?q=author%3Arrudowski" title="Bug reports">🐛</a></td>
  </tr>
</table>

<!-- markdownlint-enable -->
<!-- prettier-ignore-end -->
<!-- ALL-CONTRIBUTORS-LIST:END -->

This project follows the [all-contributors](https://github.com/all-contributors/all-contributors) specification. Contributions of any kind welcome!