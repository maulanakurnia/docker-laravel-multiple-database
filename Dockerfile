FROM php:7.4.1-apache

# Install extensions
RUN apt-get update && apt-get install -y --no-install-recommends \ 
        libpng-dev \
        zlib1g-dev \
        libxml2-dev \
        libzip-dev \
        libonig-dev \
        libpq-dev \
        zip \
        curl \
        unzip \
        git \
    && curl -sL https://deb.nodesource.com/setup_14.x -o nodesource_setup.sh \
    && bash nodesource_setup.sh \
    && apt-get install -y nodejs \
    && docker-php-ext-configure gd \
    && docker-php-ext-install \
        -j$(nproc) gd \
        zip \
        pgsql \
        mysqli \
        pdo \
        pdo_pgsql \
        pdo_mysql \
    && docker-php-source delete \
    && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN npm i npm@latest -g

COPY .docker/apache2/sites-available/000-default.conf /etc/apache2/sites-available/000-default.conf

# Copy application folder
COPY . /var/www
RUN a2enmod rewrite
RUN chown -R www-data: /var/www

RUN service apache2 restart
RUN cd /var/www && \
    /usr/local/bin/composer install --no-dev