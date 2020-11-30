FROM php:7.3-fpm as intermediate

# Install system packages
ENV DEBIAN_FRONTEND=noninteractive
SHELL ["/bin/bash", "-o", "pipefail", "-c"]
WORKDIR /var/www/html

# hadolint ignore=DL3008
RUN apt-get update && \
    apt-get -y install \
            libicu-dev \
            libgmp-dev \
        --no-install-recommends && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
    ln -s /usr/include/x86_64-linux-gnu/gmp.h /usr/local/include/

RUN docker-php-ext-install \
        pdo_mysql \
        gmp

ARG WITH_XDEBUG=false
RUN if [[ $WITH_XDEBUG = "true" ]]; then \
    pecl install xdebug-2.7.0 \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
  fi

COPY provision/php-fpm.conf /usr/local/etc/php-fpm.d/api-www.conf

FROM intermediate
COPY --chown=www-data:www-data ./ /var/www/html
