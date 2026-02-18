#!/bin/sh
set -e
cd /var/www

# Install dependencies when volume mount overwrites vendor (e.g. after git clone)
if [ ! -f vendor/autoload.php ]; then
    composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist
    chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true
    chmod -R 775 storage bootstrap/cache 2>/dev/null || true
fi

exec "$@"
