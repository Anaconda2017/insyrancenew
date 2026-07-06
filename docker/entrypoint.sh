#!/bin/sh

echo "Starting application setup..."

# Set proper permissions first
chown -R www-data:www-data /var/www/html/storage 2>/dev/null || true
chown -R www-data:www-data /var/www/html/bootstrap/cache 2>/dev/null || true
chmod -R 775 /var/www/html/storage 2>/dev/null || true
chmod -R 775 /var/www/html/bootstrap/cache 2>/dev/null || true

# Create storage link if not exists
php artisan storage:link 2>/dev/null || true

# Clear caches
php artisan config:clear 2>/dev/null || true
php artisan route:clear 2>/dev/null || true
php artisan view:clear 2>/dev/null || true

echo "Basic setup completed!"

# Test database connection in background (don't block startup)
(
    MAX_TRIES=10
    COUNT=0
    echo "Testing database connection in background..."
    until php -r "new PDO('mysql:host=${DB_HOST};port=${DB_PORT};dbname=${DB_DATABASE}', '${DB_USERNAME}', '${DB_PASSWORD}');" 2>/dev/null || [ $COUNT -eq $MAX_TRIES ]; do
        COUNT=$((COUNT+1))
        echo "DB check (${COUNT}/${MAX_TRIES})..."
        sleep 2
    done
    
    if [ $COUNT -eq $MAX_TRIES ]; then
        echo "WARNING: Could not connect to database. Please check DB credentials."
    else
        echo "Database connected! Running migrations..."
        php artisan migrate --force --no-interaction 2>&1 || echo "Migration skipped"
    fi
) &

echo "Application ready to start!"

# Execute the main command
exec "$@"

