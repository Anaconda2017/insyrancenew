# دليل البدء السريع - Quick Start Guide 🚀

## الخطوات السريعة للنشر على Coolify

### 1️⃣ رفع الكود على GitHub

```bash
git init
git add .
git commit -m "Initial commit"
git remote add origin https://github.com/YOUR_USERNAME/your-repo-name.git
git branch -M main
git push -u origin main
```

### 2️⃣ في Coolify Dashboard

1. اضغط **New Resource** → **Application**
2. اختر GitHub repository
3. Build Pack: **Dockerfile**

### 3️⃣ المتغيرات البيئية المطلوبة

```env
APP_NAME=Insurance
APP_ENV=production
APP_KEY=base64:XXXXX  # استخدم: php artisan key:generate --show
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=your-db-host
DB_PORT=3306
DB_DATABASE=insurance
DB_USERNAME=your-username
DB_PASSWORD=your-password

JWT_SECRET=XXXXX  # استخدم: php artisan jwt:secret --show
JWT_TTL=60
JWT_REFRESH_TTL=20160

LOG_CHANNEL=stack
LOG_LEVEL=error
```

### 4️⃣ بعد النشر - في Coolify Terminal

```bash
php artisan migrate --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 5️⃣ اختبار التطبيق

```bash
curl https://your-domain.com/api/health
```

يجب أن ترى: `{"status":"ok","database":"connected"}`

---

## ✅ Checklist

- [ ] رفعت الكود على GitHub
- [ ] أنشأت التطبيق في Coolify
- [ ] أضفت المتغيرات البيئية
- [ ] أنشأت قاعدة البيانات
- [ ] نشرت التطبيق (Deploy)
- [ ] نفذت أوامر ما بعد النشر
- [ ] أضفت Domain
- [ ] اختبرت `/api/health`

---

## 🐛 حل المشاكل الشائعة

| المشكلة | الحل |
|---------|------|
| Database connection failed | تحقق من بيانات DB في Environment Variables |
| 500 Error | تأكد من ضبط APP_KEY و JWT_SECRET |
| Permission denied | `chmod -R 775 storage bootstrap/cache` |
| Route not found | `php artisan route:clear && php artisan route:cache` |

---

## 📚 مزيد من التفاصيل

للحصول على دليل مفصل، راجع:
- [README.md](README.md) - التوثيق الكامل
- [DEPLOYMENT.md](DEPLOYMENT.md) - دليل النشر المفصل

---

## 💡 نصائح

1. **احتفظ بنسخة آمنة من `.env`** - لا ترفعها على GitHub أبداً
2. **فعّل SSL** - Coolify يوفر SSL مجاني تلقائياً
3. **راقب Logs** - تحقق من logs بانتظام في Coolify Dashboard
4. **النسخ الاحتياطي** - اعمل backup دوري لقاعدة البيانات

---

**جاهز للبدء؟** ابدأ من الخطوة 1️⃣ واتبع التعليمات! 🎉

