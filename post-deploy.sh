#!/bin/sh
# Post-Deployment Commands for Coolify
# Run these commands in Coolify Terminal after each deployment

echo "Running post-deployment setup..."

# Clear caches (do not fail deploy if artisan is unavailable)
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true
php artisan cache:clear || true

# Run migrations
php artisan migrate --force || true

# Create storage link
php artisan storage:link || true

# Cache for production
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

echo "Post-deployment completed successfully!"

