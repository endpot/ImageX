FROM php:7.2-fpm

MAINTAINER endpot@gmail.com

# more extension
RUN apt-get update \
    && apt-get install -y libmemcached-dev libz-dev libpq-dev \
        libjpeg-dev libpng-dev libfreetype6-dev libssl-dev \
        libmcrypt-dev libxml2-dev openssh-server libmagickwand-dev git cron nano \
    && :\
    && docker-php-ext-configure gd --with-jpeg-dir=/usr/include/ --with-freetype-dir=/usr/include/ \
    && docker-php-ext-install gd \
    && :\
    && docker-php-ext-install soap \
    && :\
    && docker-php-ext-install pcntl \
    && :\
    && docker-php-ext-install zip \
    && :\
    && docker-php-ext-install pdo_mysql \
    && :\
    && docker-php-ext-install bcmath \
    && :\
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && :\
    && docker-php-ext-install exif \
    && docker-php-ext-install mbstring \
    && docker-php-ext-install gettext \
    && docker-php-ext-install opcache \
    && rm -rf /var/lib/apt/lists/*

# install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --quiet \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer

# set cron job
RUN echo "* * * * * cd /var/www/ && php artisan schedule:run >> /dev/null 2>&1" >> /etc/cron.d/laravel-scheduler \
    && chmod 0644 /etc/cron.d/laravel-scheduler

RUN usermod -u 1000 www-data

COPY . /var/www
COPY ./public /var/www/html

WORKDIR /var/www

RUN mv .env.example .env \
    && composer install \
    && php artisan key:generate

EXPOSE 9000
CMD ["php-fpm"]
