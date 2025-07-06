# single stage best practice
FROM php:8.2-apache

# install system dependencies
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg-dev \
    libpng-dev \
    libwebp-dev \
    curl \
    git \
    zip unzip \
    nodejs \
    npm \
    --no-install-recommends \
    && apt-get autoclean -y \
    && rm -rf /var/lib/apt/lists/*

# php extensions
ADD https://raw.githubusercontent.com/mlocati/docker-php-extension-installer/master/install-php-extensions /usr/local/bin/
RUN chmod uga+x /usr/local/bin/install-php-extensions && sync
RUN install-php-extensions \
    bcmath bz2 calendar exif gd intl ldap mcrypt memcached \
    mysqli opcache pdo_mysql pdo_pgsql pgsql redis soap xsl zip sockets iconv mbstring

# apache config
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN a2enmod rewrite headers

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

# copy source code
COPY . .

# install php dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# install node dependencies
RUN npm install

# build vite
RUN npm run build

# permissions
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# php uploads
RUN echo "file_uploads = On\n" \
         "memory_limit = 1024M\n" \
         "upload_max_filesize = 512M\n" \
         "post_max_size = 512M\n" \
         "max_execution_time = 1200\n" \
         > /usr/local/etc/php/conf.d/uploads.ini



RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
