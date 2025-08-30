#!/bin/bash

set -e

# clear config/view cache BEFORE vite build
php artisan optimize:clear

# then run vite build
# npm run build

# then cache again
php artisan config:cache
php artisan event:cache
php artisan route:cache
php artisan view:cache
