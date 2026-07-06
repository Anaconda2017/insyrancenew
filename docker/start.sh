#!/bin/sh

echo "Starting application..."

# Create .env from .env.example if not exists
if [ ! -f /var/www/html/.env ] && [ -f /var/www/html/.env.example ]; then
    echo "Creating .env from .env.example..."
    cp /var/www/html/.env.example /var/www/html/.env
fi

# Set FULL permissions for all files
echo "Setting full permissions for all files..."
chown -R www-data:www-data /var/www/html
chmod -R 777 /var/www/html
chmod -R 755 /var/www/html/storage
chmod -R 755 /var/www/html/bootstrap/cache
chmod 644 /var/www/html/.env 2>/dev/null || true

# Create storage link
php artisan storage:link 2>/dev/null || true

# Clear caches
php artisan config:clear 2>/dev/null || true
php artisan route:clear 2>/dev/null || true

# Create nginx cache and temp directories
echo "Creating nginx cache and temp directories..."
mkdir -p /var/cache/nginx
mkdir -p /var/lib/nginx/tmp/fastcgi
mkdir -p /var/lib/nginx/tmp/proxy
mkdir -p /var/lib/nginx/tmp/client_body
chown -R www-data:www-data /var/cache/nginx
chown -R www-data:www-data /var/lib/nginx
chmod -R 755 /var/cache/nginx
chmod -R 755 /var/lib/nginx

echo "Starting services..."

# Kill any existing nginx processes
pkill -f nginx 2>/dev/null || true
sleep 1

# Start PHP-FPM in background
php-fpm -F -R &
PHP_PID=$!

# Wait a bit for PHP-FPM to start
sleep 2

# Start Nginx in foreground
echo "Starting Nginx..."
exec nginx -g 'daemon off;'

