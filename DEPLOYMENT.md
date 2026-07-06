# دليل النشر على Coolify

هذا الدليل يوضح كيفية نشر المشروع على Coolify بالتفصيل.

## المتطلبات الأساسية

1. حساب على GitHub
2. Coolify Dashboard مثبت على السيرفر
3. قاعدة بيانات MySQL

## خطوات النشر

### 1. رفع المشروع على GitHub

```bash
# تهيئة Git (إذا لم يكن مهيئاً)
git init

# إضافة جميع الملفات
git add .

# إنشاء أول commit
git commit -m "Initial commit - Insurance Management System"

# إضافة remote repository
git remote add origin https://github.com/YOUR_USERNAME/insurance.git

# رفع الكود
git branch -M main
git push -u origin main
```

### 2. إعداد المشروع على Coolify

#### أ. إنشاء التطبيق

1. سجل الدخول إلى Coolify Dashboard
2. اضغط على "New Resource"
3. اختر "Application"
4. اختر "Public Repository" وأدخل رابط GitHub repo
5. اختر "Dockerfile" كـ Build Pack

#### ب. تكوين المتغيرات البيئية

في صفحة الإعدادات، أضف المتغيرات التالية:

```env
# Application Settings
APP_NAME=Insurance
APP_ENV=production
APP_KEY=base64:YOUR_KEY_HERE
APP_DEBUG=false
APP_URL=https://your-domain.com

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=your-db-host
DB_PORT=3306
DB_DATABASE=insurance
DB_USERNAME=your-db-username
DB_PASSWORD=your-db-password

# JWT Configuration
JWT_SECRET=your-jwt-secret-here
JWT_TTL=60
JWT_REFRESH_TTL=20160

# Cache & Session
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

# Logging
LOG_CHANNEL=stack
LOG_LEVEL=error

# Mail Configuration (اختياري)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"
```

#### ج. توليد المفاتيح

قبل النشر، قم بتوليد المفاتيح المطلوبة:

**توليد APP_KEY:**
```bash
php artisan key:generate --show
```

**توليد JWT_SECRET:**
```bash
php artisan jwt:secret --show
```

### 3. تكوين قاعدة البيانات

#### إنشاء قاعدة بيانات MySQL في Coolify:

1. من Dashboard، اضغط على "New Resource"
2. اختر "Database"
3. اختر "MySQL"
4. احفظ بيانات الاتصال

أو استخدم قاعدة بيانات خارجية وأدخل بيانات الاتصال في المتغيرات البيئية.

### 4. إعدادات إضافية في Coolify

#### أ. تكوين Port
- Port: `80` (افتراضي)
- Protocol: `http`

#### ب. تكوين Health Check
- Health Check URL: `/api/health`
- Health Check Interval: `30s`

#### ج. تكوين Storage (مهم!)

أضف Volume للملفات الثابتة:
- Source: `/var/www/html/storage`
- Destination: `storage-data`

أضف Volume آخر:
- Source: `/var/www/html/public/uploads`
- Destination: `uploads-data`

### 5. النشر الأول

1. اضغط على "Deploy"
2. انتظر حتى ينتهي البناء (Build)
3. بعد النشر بنجاح، افتح Terminal في Coolify

### 6. تشغيل أوامر ما بعد النشر

في Coolify Terminal، قم بتشغيل:

```bash
# تشغيل Migrations
php artisan migrate --force

# إنشاء Storage Link
php artisan storage:link

# Cache Configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Clear OPcache
php artisan opcache:clear
```

### 7. إضافة Domain

1. في إعدادات التطبيق، اذهب إلى "Domains"
2. أضف Domain الخاص بك
3. Coolify سيقوم بتفعيل SSL تلقائياً عبر Let's Encrypt

### 8. التحقق من التشغيل

تحقق من أن التطبيق يعمل بشكل صحيح:

```bash
# اختبار Health Check
curl https://your-domain.com/api/health

# يجب أن ترى:
# {"status":"ok","database":"connected","timestamp":"2024-..."}
```

## التحديثات المستقبلية

عند إضافة تحديثات جديدة:

```bash
# على جهازك المحلي
git add .
git commit -m "وصف التحديث"
git push origin main
```

Coolify سيقوم بالنشر التلقائي (إذا كان Auto Deploy مفعلاً)، أو اضغط يدوياً على "Deploy" في Dashboard.

## استكشاف الأخطاء

### مشكلة: Database connection failed

**الحل:**
- تحقق من بيانات الاتصال في Environment Variables
- تأكد من أن Database Server يعمل
- تحقق من Firewall rules

### مشكلة: Permission denied on storage

**الحل:**
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### مشكلة: 500 Internal Server Error

**الحل:**
1. تحقق من Logs في Coolify
2. تأكد من أن APP_KEY مضبوط
3. تشغيل: `php artisan config:clear`

### مشكلة: Route not found

**الحل:**
```bash
php artisan route:clear
php artisan route:cache
```

## النسخ الاحتياطي

### نسخ احتياطي لقاعدة البيانات:

```bash
# تصدير قاعدة البيانات
mysqldump -u username -p insurance > backup.sql

# استيراد قاعدة البيانات
mysql -u username -p insurance < backup.sql
```

### نسخ احتياطي للملفات:

قم بعمل backup دوري لمجلدات:
- `/storage/app`
- `/public/uploads`

## الأمان

### توصيات الأمان:

1. ✅ تأكد من أن `APP_DEBUG=false` في production
2. ✅ استخدم HTTPS فقط (SSL)
3. ✅ قم بتحديث المكتبات بانتظام: `composer update`
4. ✅ غير JWT_SECRET بشكل دوري
5. ✅ راقب Logs بانتظام
6. ✅ استخدم Strong Passwords لقاعدة البيانات

## المراقبة

### مراقبة الأداء:

```bash
# مراقبة استخدام الذاكرة
php artisan opcache:status

# مشاهدة Logs
tail -f storage/logs/laravel.log
```

## الدعم

للمساعدة أو الإبلاغ عن مشاكل، يرجى فتح Issue على GitHub.

---

**ملاحظة مهمة:** احتفظ بنسخة من ملف `.env` في مكان آمن ولا ترفعه أبداً على GitHub!

