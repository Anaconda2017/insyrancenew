# Insurance Management System

A comprehensive Laravel-based insurance management system supporting multiple insurance types (Motor, Building, Medical, and Job insurance).

## Features

- 🚗 Motor Insurance Management
- 🏢 Building Insurance Management
- 🏥 Medical Insurance Management
- 💼 Job Insurance Management
- 📊 Claims Management
- 👥 Client Management
- 📝 Request & Lead Tracking
- 🌐 Multi-language Support (Arabic & English)
- 📱 RESTful API with JWT Authentication

## Requirements

- PHP >= 7.3
- MySQL >= 5.7 or MySQL 8.0
- Composer
- Node.js & NPM (for frontend assets)

## Installation

### Local Development

1. Clone the repository:
```bash
git clone <your-repo-url>
cd insurance
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install Node dependencies:
```bash
npm install
```

4. Copy environment file:
```bash
cp .env.example .env
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Generate JWT secret:
```bash
php artisan jwt:secret
```

7. Configure your database in `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=insurance
DB_USERNAME=root
DB_PASSWORD=your_password
```

8. Run migrations:
```bash
php artisan migrate
```

9. Seed the database (optional):
```bash
php artisan db:seed
```

10. Create storage link:
```bash
php artisan storage:link
```

11. Start the development server:
```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

### Docker Development

1. Clone the repository
2. Copy `.env.example` to `.env` and configure as needed
3. Build and run with Docker Compose:
```bash
docker-compose up -d
```

The application will be available at:
- App: `http://localhost:8080`
- PHPMyAdmin: `http://localhost:8081`

## Deployment to Coolify

### Prerequisites

1. A Coolify instance running
2. GitHub repository with the code
3. Database server (MySQL)

### Deployment Steps

1. **Push to GitHub:**
```bash
git init
git add .
git commit -m "Initial commit"
git branch -M main
git remote add origin <your-github-repo-url>
git push -u origin main
```

2. **In Coolify Dashboard:**

   - Click "New Resource" → "Application"
   - Select your GitHub repository
   - Choose "Dockerfile" as build pack
   - Set the following environment variables:

```env
APP_NAME=Insurance
APP_ENV=production
APP_KEY=<generate-with-php-artisan-key:generate>
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=<your-db-host>
DB_PORT=3306
DB_DATABASE=insurance
DB_USERNAME=<your-db-user>
DB_PASSWORD=<your-db-password>

JWT_SECRET=<generate-with-php-artisan-jwt:secret>
JWT_TTL=60
JWT_REFRESH_TTL=20160

LOG_CHANNEL=stack
LOG_LEVEL=error
SESSION_DRIVER=file
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
```

3. **Post-Deployment Commands** (run in Coolify terminal):
```bash
php artisan migrate --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan opcache:clear
```

4. **Configure Domain:**
   - Set your custom domain in Coolify
   - SSL will be automatically configured

### Important Notes for Production

1. **Storage Permissions:** Ensure `storage` and `bootstrap/cache` directories are writable
2. **Environment Variables:** Never commit `.env` file to Git
3. **Database Backups:** Set up regular database backups
4. **File Uploads:** Configure proper storage driver (S3, etc.) for persistent file storage
5. **Logging:** Monitor logs in Coolify dashboard

### Health Check

The application includes a health check endpoint at `/api/health` that Coolify uses to monitor application status.

## API Documentation

### Authentication

The API uses JWT (JSON Web Tokens) for authentication.

**Login:**
```http
POST /api/login
Content-Type: application/json

{
  "email": "user@example.com",
  "password": "password"
}
```

**Response:**
```json
{
  "access_token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
  "token_type": "bearer",
  "expires_in": 3600
}
```

Use the token in subsequent requests:
```http
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGc...
```

## File Structure

```
insurance/
├── app/                    # Application logic
│   ├── Http/Controllers/  # API & Web Controllers
│   ├── Models/            # Eloquent Models
│   └── ...
├── config/                # Configuration files
├── database/              # Migrations & Seeders
├── docker/                # Docker configuration
│   ├── nginx/            # Nginx configs
│   └── supervisor/       # Supervisor configs
├── public/               # Public assets
├── resources/            # Views & frontend assets
├── routes/               # Route definitions
├── storage/              # File storage
└── Dockerfile           # Docker build file
```

## Troubleshooting

### Common Issues

**Issue:** "Permission denied" on storage
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

**Issue:** JWT secret not set
```bash
php artisan jwt:secret
```

**Issue:** Database connection failed
- Check DB credentials in `.env`
- Ensure MySQL server is running
- Verify firewall rules

## Support

For support, please open an issue on GitHub or contact the development team.

## License

This project is proprietary software. All rights reserved.
