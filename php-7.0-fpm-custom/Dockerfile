FROM php:7.1-fpm-stretch

# Install modules
RUN apt-get update && apt-get install -y \
	libfreetype6-dev \
	libjpeg62-turbo-dev \
	libmcrypt-dev \
	libpng-dev

RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
	&& docker-php-ext-install gd

RUN docker-php-ext-install mcrypt

RUN docker-php-ext-install mysqli

RUN pecl install --onlyreqdeps --force redis \
	&& rm -rf /tmp/pear \
	&& docker-php-ext-enable redis

CMD ["php-fpm"]
