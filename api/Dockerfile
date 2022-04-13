FROM php:8.1-fpm as intermediate

SHELL ["/bin/bash", "-o", "pipefail", "-c"]
WORKDIR /var/www/html

# hadolint ignore=DL3022
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions pdo_mysql gmp

ARG WITH_XDEBUG=false
RUN if [[ $WITH_XDEBUG = "true" ]]; then \
    install-php-extensions xdebug-^3.1; \
  fi

COPY provision/php-fpm.conf /usr/local/etc/php-fpm.d/api-www.conf

FROM intermediate
COPY --chown=www-data:www-data ./ /var/www/html
