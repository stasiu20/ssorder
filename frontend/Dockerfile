# hadolint ignore=DL3006
FROM php:7.3-apache as build

# Install system packages
ENV DEBIAN_FRONTEND=noninteractive
SHELL ["/bin/bash", "-o", "pipefail", "-c"]
WORKDIR /app

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
        intl \
        gmp \
        && echo -e "no\nno\nno\n" | pecl install redis-5.2.1 \
        && echo "extension=redis.so" | tee /usr/local/etc/php/conf.d/redis.ini

RUN mkdir -p /artifacts \
    && cp -r --parents /usr/local/lib/php/extensions/no-debug-non-zts-20180731/ /artifacts/ \
    && cp -r --parents /usr/local/etc/php/conf.d/ /artifacts/

# hadolint ignore=DL3006
FROM php:7.3-apache as intermediate

ARG WITH_XDEBUG=false

# Install system packages
ENV DEBIAN_FRONTEND=noninteractive
SHELL ["/bin/bash", "-o", "pipefail", "-c"]
WORKDIR /app

RUN if [[ $WITH_XDEBUG = "true" ]]; then \
    pecl install xdebug-3.0.1 \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.mode=develop,debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
  fi

RUN apt-get update && \
    apt-get -y install \
            libicu63=63.1-6+deb10u1 \
            libgmp10=2:6.1.2+dfsg-4 \
        --no-install-recommends && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
    ln -s /usr/include/x86_64-linux-gnu/gmp.h /usr/local/include/

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
