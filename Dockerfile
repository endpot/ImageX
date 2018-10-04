FROM richarvey/nginx-php-fpm

MAINTAINER endpot@gmail.com

# set cron job
RUN echo "* * * * * cd /var/www/ && php artisan schedule:run >> /dev/null 2>&1" >> /etc/cron.d/laravel-scheduler \
    && chmod 0644 /etc/cron.d/laravel-scheduler

COPY .nginx.conf /etc/nginx/nginx.conf

COPY . /var/www

WORKDIR /var/www

RUN rm html -rf \
    && mv .env.example .env \
    && composer install \
    && php artisan key:generate
