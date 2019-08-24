FROM richarvey/nginx-php-fpm:latest

LABEL maintainer="endpot@gmail.com"

# install extension
RUN apk update \
    && apk add --no-cache gettext-dev \
    && docker-php-ext-install pcntl \
    && docker-php-ext-install mbstring \
    && docker-php-ext-install exif \
    && docker-php-ext-install bcmath \
    && docker-php-ext-install sockets \
    && docker-php-ext-install gettext \
    && docker-php-ext-install shmop \
    && docker-php-ext-install sysvsem

ADD docker/conf/nginx-site.conf /etc/nginx/sites-available/default.conf
ADD docker/conf/nginx-site-ssl.conf /etc/nginx/sites-available/default-ssl.conf
RUN rm /etc/nginx/sites-enabled/default.conf -rf \
	&& ln -s /etc/nginx/sites-available/default.conf /etc/nginx/sites-enabled/default.conf \
	# tweak php-fpm config
	&& echo "memory_limit = 256M"  >> ${php_vars} \
	&& sed -i \
		-e "s/pm.max_children = 4/pm.max_children = 16/g" \
		-e "s/pm.start_servers = 3/pm.start_servers = 4/g" \
		-e "s/pm.min_spare_servers = 2/pm.min_spare_servers = 2/g" \
        -e "s/pm.max_spare_servers = 4/pm.max_spare_servers = 8/g" \
		-e "s/;pm.max_requests = 200/pm.max_requests = 256/g" \
		${fpm_conf}

ENV TZ="Asia/Shanghai"

COPY . /var/www/html

WORKDIR /var/www/html

RUN cp docker/scripts /var/www/html -r \
    && composer install \
    && mv .env.example .env \
    && chgrp -R nginx storage /var/www/html/bootstrap/cache \
    && chmod -R ug+rwx storage /var/www/html/bootstrap/cache \
    && chgrp -R nginx storage /var/www/html/storage \
    && chmod -R ug+rwx storage /var/www/html/storage \
    && php artisan key:generate
