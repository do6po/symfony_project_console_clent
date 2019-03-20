FROM php:7.2-fpm-stretch

RUN apt-get update \
	&& apt-get install -y \
		zip \
		unzip \
		nano \
		wget \
		curl \
		mysql-client \
		zlib1g-dev \
		libicu-dev \
		libmemcached-dev \
		g++ \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

# Run docker-php-ext-install for available extensions
RUN docker-php-ext-configure intl \
    && docker-php-ext-install pdo pdo_mysql opcache intl

COPY ./docker/prod/php_init.sh /usr/bin/
RUN chmod +x  /usr/bin/php_init.sh
