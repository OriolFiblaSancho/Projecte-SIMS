# Official image of PHP with Apache
FROM php:8.2-apache

RUN apt-get update && apt-get upgrade -y \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql \
    && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite

# Allow .htaccess overrides for routing
COPY apache-allow-override.conf /etc/apache2/conf-available/allow-override.conf
RUN a2enconf allow-override

COPY ./ /var/www/html
