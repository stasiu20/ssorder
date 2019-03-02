FROM phpstorm/php-56-apache-xdebug-25

# Install system packages
ENV DEBIAN_FRONTEND=noninteractive
RUN apt-get update && \
    apt-get -y install \
            vim \
            git \
            zip \
            unzip \
            libicu-dev \
        --no-install-recommends && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN rm -rf /var/www/html && ln -s /app/frontend/web/ /var/www/html || true
RUN a2enmod rewrite headers
RUN docker-php-ext-install \
        pdo_mysql \
        intl

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- \
        --filename=composer \
        --install-dir=/usr/local/bin
RUN composer global require fxp/composer-asset-plugin
