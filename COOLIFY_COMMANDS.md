# 🔧 Commands to Run in Coolify Terminal

## Step 1: Check Environment
```bash
# Check if .env exists
ls -la /var/www/html/.env

# Check database connection
php artisan tinker --execute="echo 'DB Test: '; try { DB::connection()->getPdo(); echo 'Connected!'; } catch(Exception \$e) { echo 'Failed: ' . \$e->getMessage(); }"
```

## Step 2: Clear and Setup
```bash
# Clear all caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Run migrations
php artisan migrate --force

# Create storage link
php artisan storage:link
```

## Step 3: Test Routes
```bash
# List all routes
php artisan route:list | grep health
php artisan route:list | grep getHomeData

# Test artisan directly
php artisan tinker --execute="echo route('health');"
```

## Step 4: Check Logs
```bash
# Check Laravel logs
tail -50 /var/www/html/storage/logs/laravel.log

# Check Nginx error logs
tail -50 /var/log/nginx/error.log

# Check PHP-FPM logs
tail -50 /var/log/php7/error.log
```

## Step 5: Manual Test
```bash
# Test from inside container
curl http://localhost/api/health
curl http://localhost/api/getHomeData
```

---

## 📋 Quick Diagnosis Command (Run this first):
```bash
echo "=== ENV CHECK ===" && \
ls -la /var/www/html/.env && \
echo "" && \
echo "=== PHP VERSION ===" && \
php -v && \
echo "" && \
echo "=== ARTISAN TEST ===" && \
php artisan --version && \
echo "" && \
echo "=== ROUTE TEST ===" && \
php artisan route:list | head -20 && \
echo "" && \
echo "=== CURL TEST ===" && \
curl -s http://localhost/api/health && \
echo "" && \
echo "=== NGINX ERROR ===" && \
tail -10 /var/log/nginx/error.log
```

