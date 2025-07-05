#!/bin/sh

# .env copy kore set korbo
echo "Copying .env file..."
cp /opt/laravel/.env /opt/laravel/.env

# Laravel permission fix
echo "Fixing permissions..."
chown -R www-data:www-data /opt/laravel/storage /opt/laravel/bootstrap/cache
chmod -R 775 /opt/laravel/storage /opt/laravel/bootstrap/cache

# Laravel key generate (if needed)
if [ ! -f "/opt/laravel/.env.production" ]; then
  php artisan key:generate
fi

# migrate + cache
echo "Running migrations..."
php artisan migrate --force
php artisan config:cache

# start supervisor (to handle nginx + php-fpm)
echo "Starting Supervisor..."
exec supervisord -c /etc/supervisord.conf
