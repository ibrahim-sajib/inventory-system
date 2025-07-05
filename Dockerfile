# FROM php:8.2-apache

# # copy project code
# COPY . /var/www/html

# ADD https://raw.githubusercontent.com/mlocati/docker-php-extension-installer/master/install-php-extensions /usr/local/bin/

# RUN chmod uga+x /usr/local/bin/install-php-extensions && sync

# RUN apt-get update && apt-get install -y  \
#     libfreetype6-dev \
#     libjpeg-dev \
#     libpng-dev \
#     libwebp-dev \
#     --no-install-recommends \
#     && docker-php-ext-enable opcache \
#     && docker-php-ext-configure gd --with-freetype --with-jpeg \
#     && docker-php-ext-install pdo_mysql -j$(nproc) gd \
#     && apt-get autoclean -y \
#     && rm -rf /var/lib/apt/lists/*

# RUN DEBIAN_FRONTEND=noninteractive apt-get update -q \
#     && DEBIAN_FRONTEND=noninteractive apt-get install -qq -y \
#       curl \
#       git \
#       zip unzip \
#     && install-php-extensions \
#       bcmath \
#       bz2 \
#       calendar \
#       exif \
#       gd \
#       intl \
#       ldap \
#       mcrypt \
#       memcached \
#       mysqli \
#       opcache \
#       pdo_mysql \
#       pdo_pgsql \
#       pgsql \
#       redis \
#       soap \
#       xsl \
#       zip \
#       sockets \
#       iconv \
#       mbstring \
#       && a2enmod rewrite

# # Update apache conf to point to application public directory
# ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
# RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
# RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
# # Enable headers module
# RUN a2enmod rewrite headers

# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# RUN composer install --no-interaction --prefer-dist --optimize-autoloader


# # after composer install
# # Install Node.js and npm
# RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
#     apt-get install -y nodejs

    
# COPY package*.json ./
# # Update npm to the latest version
# RUN npm install npm@10.8.2 -g

# COPY . .
# RUN npm run build

# # permission fix for storage + cache
# RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
#     && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache


# # Update uploads config
# RUN echo "file_uploads = On\n" \
#          "memory_limit = 1024M\n" \
#          "upload_max_filesize = 512M\n" \
#          "post_max_size = 512M\n" \
#          "max_execution_time = 1200\n" \
#          > /usr/local/etc/php/conf.d/uploads.ini

# RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf




FROM php:8.2-apache

# copy project code
COPY . /var/www/html

ADD https://raw.githubusercontent.com/mlocati/docker-php-extension-installer/master/install-php-extensions /usr/local/bin/

RUN chmod uga+x /usr/local/bin/install-php-extensions && sync

RUN apt-get update && apt-get install -y  \
    libfreetype6-dev \
    libjpeg-dev \
    libpng-dev \
    libwebp-dev \
    --no-install-recommends \
    && docker-php-ext-enable opcache \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql -j$(nproc) gd \
    && apt-get autoclean -y \
    && rm -rf /var/lib/apt/lists/*

RUN DEBIAN_FRONTEND=noninteractive apt-get update -q \
    && DEBIAN_FRONTEND=noninteractive apt-get install -qq -y \
      curl \
      git \
      zip unzip \
    && install-php-extensions \
      bcmath \
      bz2 \
      calendar \
      exif \
      gd \
      intl \
      ldap \
      mcrypt \
      memcached \
      mysqli \
      opcache \
      pdo_mysql \
      pdo_pgsql \
      pgsql \
      redis \
      soap \
      xsl \
      zip \
      sockets \
      iconv \
      mbstring \
      && a2enmod rewrite

# Update apache conf to point to application public directory
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
# Enable headers module
RUN a2enmod rewrite headers

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

# Copy package.json
COPY package*.json ./

# Install npm dependencies including devDependencies
RUN npm install --include=dev

# copy all source
COPY . .

# build vite
RUN npm run build

RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache



# permission fix for storage + cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache


# Update uploads config
RUN echo "file_uploads = On\n" \
         "memory_limit = 1024M\n" \
         "upload_max_filesize = 512M\n" \
         "post_max_size = 512M\n" \
         "max_execution_time = 1200\n" \
         > /usr/local/etc/php/conf.d/uploads.ini

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf




