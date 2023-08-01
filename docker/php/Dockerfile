FROM php:8.1-fpm

# Locales
RUN apt-get update && apt-get install -y locales && \
    echo 'en_US.UTF-8 UTF-8' >> /etc/locale.gen  && \
    echo 'en_US ISO-8859-1' >> /etc/locale.gen  && \
    echo 'de_AT.UTF-8 UTF-8' >> /etc/locale.gen  && \
    echo 'de_AT ISO-8859-1' >> /etc/locale.gen  && \
    echo 'de_DE.UTF-8 UTF-8' >> /etc/locale.gen  && \
    echo 'de_DE ISO-8859-1' >> /etc/locale.gen  && \
    locale-gen \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Dependencies and Utils
RUN apt-get update && apt-get install -y --no-install-recommends \
    libpng-dev \
    libjpeg-dev \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    libcurl4-openssl-dev \
    libxml2-dev \
    unzip \
    git \
    wget \
    openssh-client \
    cron \
    default-mysql-client \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Intl Library Dependencies
RUN docker-php-ext-configure intl \
  && docker-php-ext-install intl

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

RUN apt-get update && apt-get install -y \
    imagemagick libmagickwand-dev --no-install-recommends \
    && pecl install imagick \
    && docker-php-ext-enable imagick

# PHP Modules
RUN docker-php-ext-install pcntl zip bcmath exif pdo_mysql mbstring exif pcntl bcmath gd pdo pdo_mysql


# Install Redis PHP extensions
RUN pecl install -o -f redis \
&&  rm -rf /tmp/pear \
&&  docker-php-ext-enable redis



# XDebug
RUN pecl install xdebug; \
    docker-php-ext-enable xdebug

RUN cd /opt && \
 wget https://phar.phpunit.de/phpunit-9.phar && \
 chmod +x phpunit-9.phar && \
 mv phpunit-9.phar /usr/local/bin/phpunit

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Composer cache
RUN mkdir -p /.composer/cache && chmod -R 777 /.composer/cache

ENV COMPOSER_HOME=/.composer

# Arguments defined in docker-compose.yml
ARG USER_ID
ARG GROUP_ID

# Create system user to run Composer and Artisan Commands
RUN if [ ${USER_ID:-0} -ne 0 ] && [ ${GROUP_ID:-0} -ne 0 ]; then \
    userdel -f www-data &&\
    if getent group www-data ; then groupdel www-data; fi &&\
    groupadd -g ${GROUP_ID} www-data &&\
    useradd -l -u ${USER_ID} -g www-data www-data &&\
    install -d -m 0755 -o www-data -g www-data /home/www-data &&\
    chown --changes --silent --no-dereference --recursive \
          --from=33:33 ${USER_ID}:${GROUP_ID} \
        /home/www-data \
        /.composer \
;fi

# Set Locales
RUN locale-gen de_AT.UTF-8
ENV LANG de_AT.UTF-8
ENV LANGUAGE de_AT:en
ENV LC_ALL de_AT.UTF-8


# Set working directory
WORKDIR /var/www

USER www-data
