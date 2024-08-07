# Pin to an explicit PHP release
FROM php:8.2.7-fpm-bullseye as builder

RUN apt-get update && apt-get install -y \
    wget \
    zlib1g-dev \
    libzip-dev \
    libpng-dev \
    && pecl install redis \
    && docker-php-ext-install bcmath pdo_mysql mysqli pcntl gd zip \
    && docker-php-ext-enable bcmath pdo_mysql mysqli pcntl redis gd zip



FROM debian:11.7-slim

RUN \
    #
    # utils and build reqs
    #
    ln -snf /usr/share/zoneinfo/UTC /etc/localtime \
    && apt-get update -y \
    && apt-get upgrade -y \
    && apt-get install -y --no-install-recommends --no-install-suggests \
    ca-certificates \
    curl \
    unzip \
    zip \
    build-essential \
    lsb-release \
    gnupg \
    #
    # supervisor
    #
    supervisor \
    #
    # nginx
    #
    nginx-extras \
    #
    # Node JS (npm needed)
    #
    #npm \
    #
    # PHP dependencies
    #
    argon2 \
    libargon2-0 \
    libargon2-0-dev \
    libreadline-dev \
    libxml2-dev \
    libssl-dev \
    libsqlite3-dev \
    libcurl4-openssl-dev \
    libonig-dev \
    libsodium-dev \
    zlib1g-dev \
    vim \
    #
    # Clean up installation artifacts to make image leaner
    #
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*


# PHP and Composer
COPY --from=builder /usr/local/etc/. /usr/local/etc
COPY --from=builder /usr/local/bin/. /usr/local/bin
COPY --from=builder /usr/local/sbin/. /usr/local/sbin
COPY --from=builder /usr/src/. /usr/src
COPY --from=builder /usr/local/lib/. /usr/local/lib
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

# Overwrite default configs
COPY nginx.conf /etc/nginx/
COPY supervisord.conf /etc/supervisor/conf.d/
COPY php.ini /usr/local/etc/php/
COPY www.conf /usr/local/etc/php-fpm.d

# Application
ENV APP_DIR=/var/www/
COPY --chown=www-data:www-data . $APP_DIR
WORKDIR $APP_DIR

# Run composer install
RUN \
    chsh -s /bin/bash www-data \
    && su -m www-data -c " \
    php -d auto_prepend_file='' -d disable_functions='' \
    /usr/local/bin/composer install \
    --optimize-autoloader \
    --no-interaction \
    --no-ansi \
    --no-progress \
    --no-scripts \
    --prefer-dist \
    --no-dev "

#RUN npm install && npm run dev

EXPOSE 8080

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]
