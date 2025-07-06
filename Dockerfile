# --- STAGE 1: Node + Composer build ---
FROM node:18 as node-builder

# set working directory
WORKDIR /app

# copy package.json & install node dependencies
COPY package*.json ./
RUN npm install

# copy composer files & install PHP dependencies
COPY composer.json composer.lock ./
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# copy application code
COPY . .

# build Vite assets (vendor now exists, so ziggy works)
RUN npm run build


# --- STAGE 2: PHP + Apache ---
FROM php:8.2-apache

# install system dependencies & PHP extensions
ADD https://raw.githubusercontent.com/mlocati/docker-php-extension-installer/master/install-php-extensions /usr/local/bin/
RUN chmod uga+x /usr/local/bin/install-php-extensions && sync

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg-dev \
    libpng-dev \
    libwebp-dev \
    curl \
    git \
    zip unzip \
    --no-install-recommends \
    && docker-php-ext-enable opcache \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql -j$(nproc) gd \
    && apt-get autoclean -y \
    && rm -rf /var/lib/apt/lists/*

RUN install-php-extensions \
    bcmath bz2 calendar exif gd intl ldap mcrypt memcached \
    mysqli opcache pdo_mysql pdo_pgsql pgsql redis soap xsl zip sockets iconv mbstring

# apache document root
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN a2enmod rewrite headers

# set working directory
WORKDIR /var/www/html

# copy only app code from previous build stage
COPY --from=node-builder /app/public /var/www/html/public
COPY --from=node-builder /app/resources /var/www/html/resources
COPY --from=node-builder /app/routes /var/www/html/routes
COPY --from=node-builder /app/vendor /var/www/html/vendor
COPY --from=node-builder /app/database /var/www/html/database
COPY --from=node-builder /app/config /var/www/html/config
COPY --from=node-builder /app/artisan /var/www/html/artisan
COPY --from=node-builder /app/bootstrap /var/www/html/bootstrap
COPY --from=node-builder /app/.env /var/www/html/.env

# (optional) if you want migrations etc:
COPY --from=node-builder /app/*.php /var/www/html/

# permission fix
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# PHP uploads config
RUN echo "file_uploads = On\n" \
         "memory_limit = 1024M\n" \
         "upload_max_filesize = 512M\n" \
         "post_max_size = 512M\n" \
         "max_execution_time = 1200\n" \
         > /usr/local/etc/php/conf.d/uploads.ini

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# artisan optimize
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

