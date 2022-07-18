FROM php:8.1-apache

RUN apt update \
    && apt install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip \
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

WORKDIR /var/www

COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

RUN usermod -u 1000 www-data
RUN groupmod -g 1000 www-data

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash
RUN apt install symfony-cli

RUN git config --global user.email "paulnikitin@gmail.com" \
    && git config --global user.name "Paul Nikitin"

RUN cp /root/.gitconfig /var/www/.gitconfig

RUN chown -R www-data:www-data /var/www
