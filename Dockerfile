FROM node:lts as builder
WORKDIR /application
COPY . .
RUN npm install
RUN npm run build

FROM php:8.2-cli

RUN apt update \
    && apt install -y zlib1g-dev g++ git libicu-dev zip libzip-dev libpq-dev zip \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install intl opcache pdo pdo_pgsql \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

WORKDIR /var/www/html

COPY --from=builder /application ./

RUN echo 'memory_limit = 512M' >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini;

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

RUN composer install

CMD ["symfony", "serve"]
