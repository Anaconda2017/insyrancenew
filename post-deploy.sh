#!/bin/sh
# Post-Deployment Commands for Coolify
# Run these commands in Coolify Terminal after each deployment

echo "Running post-deployment setup..."

# Clear all caches
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Run migrations
php artisan migrate --force

# Create storage link
php artisan storage:link

# Cache for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Post-deployment completed successfully!"

