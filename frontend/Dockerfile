# hadolint ignore=DL3006
FROM php:8.1-apache as build

# Install system packages
ENV DEBIAN_FRONTEND=noninteractive
SHELL ["/bin/bash", "-o", "pipefail", "-c"]
WORKDIR /app

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions pdo_mysql intl gmp bcmath redis-^5.3

RUN mkdir -p /artifacts \
    && cp -r --parents /usr/local/lib/php/extensions/no-debug-non-zts-20210902/ /artifacts/ \
    && cp -r --parents /usr/local/etc/php/conf.d/ /artifacts/

# hadolint ignore=DL3006
FROM php:8.1-apache as intermediate

ARG WITH_XDEBUG=false

# Install system packages
ENV DEBIAN_FRONTEND=noninteractive
SHELL ["/bin/bash", "-o", "pipefail", "-c"]
WORKDIR /app

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN if [[ $WITH_XDEBUG = "true" ]]; then \
    install-php-extensions xdebug-^3.1; \
#    pecl install xdebug-3.0.1 \
#    && docker-php-ext-enable xdebug \
#    && echo "xdebug.mode=develop,debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
#    && echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
#    && echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
#    && echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
  fi

# hadolint ignore=SC2015
RUN a2enmod rewrite headers && \
    rm -f /var/www/html/index.html && \
    rmdir /var/www/html && ln -s /app/frontend/web/ /var/www/html

RUN echo -e "expose_php=0\n" | tee /usr/local/etc/php/conf.d/ssorder.ini && \
    echo -e "ServerSignature Off\nServerTokens Prod\n" | tee /etc/apache2/conf-enabled/ssorder.conf

COPY --from=build /artifacts/ /artifacts
RUN cp -rv /artifacts/* /

FROM intermediate
COPY --chown=www-data:www-data ./ /app
