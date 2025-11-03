FROM php:8.2.28-fpm

# COPY config/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
# COPY config/php/php.ini /usr/local/etc/php/conf.d/php.ini
# COPY config/supervisor/queue.conf config/supervisor/scheduler.conf /etc/supervisor/conf.d/
# COPY config/php/docker.conf /usr/local/etc/php-fpm.d/docker.conf

# Домашний каталог контейнера
WORKDIR /var/app

# RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
# RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Обновление системы
RUN apt-get update && apt-get upgrade -y \
    && apt-get install apt-utils -y

# Устанавливаем необходимые пакеты
RUN apt-get update && apt-get install -y \
    build-essential \
    libwebp-dev libjpeg62-turbo-dev libpng-dev libxpm-dev libzip-dev libpq-dev libgmp-dev libffi-dev libssl-dev \
    libfreetype6 libfreetype6-dev \
    locales \
    jpegoptim optipng pngquant gifsicle \
    vim nano \
    zip unzip \
    git \
    curl \
    supervisor

RUN docker-php-ext-install opcache

# Расширения для работы с базой данных + gd конфигурация для работы captha
RUN docker-php-ext-install pdo pdo_mysql mysqli
RUN docker-php-ext-install gd \
      && docker-php-ext-configure gd --with-freetype --with-jpeg \
	  && docker-php-ext-install -j$(nproc) gd

RUN apt-get install -y ffmpeg

# Чистим файлы
RUN docker-php-source delete
RUN apt-get autoremove --purge -y && apt-get autoclean -y && apt-get clean -y


# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Настройка пользователя для работы контейнера и взаимодействия прав
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

USER www
