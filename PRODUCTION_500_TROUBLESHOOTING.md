# 🚨 HTTP 500 Error Troubleshooting Guide - Production

**Website:** kecamatangwaesama.id  
**Error URL:** `/profil`  
**Status:** HTTP ERROR 500

## 🔍 Quick Diagnosis Steps

### 1. Check Error Logs (PRIORITY 1)
```bash
# Check Laravel logs
tail -f storage/logs/laravel.log

# Check server error logs
tail -f /var/log/apache2/error.log  # Apache
tail -f /var/log/nginx/error.log    # Nginx
```

### 2. Run Production Fix Script
```bash
# Linux/Unix
bash fix-production-500.sh

# Windows
PowerShell -ExecutionPolicy Bypass -File fix-production-500.ps1
```

## 🛠️ Manual Troubleshooting Steps

### Step 1: Environment Configuration
```bash
# Check if .env exists
ls -la .env

# If missing, copy from hosting template
cp .env.hosting .env

# Verify critical settings
grep -E "APP_KEY|APP_ENV|APP_DEBUG|DB_" .env
```

### Step 2: Clear All Caches
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan event:clear
```

### Step 3: Database Issues
```bash
# Test database connection
php artisan tinker
# In tinker: DB::connection()->getPdo();

# Run pending migrations
php artisan migrate:status
php artisan migrate --force
```

### Step 4: File Permissions
```bash
# Set correct permissions
find . -type f -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;
chmod -R 775 storage bootstrap/cache
```

### Step 5: Dependencies
```bash
# Reinstall dependencies
composer install --no-dev --optimize-autoloader

# Regenerate autoload
composer dump-autoload
```

### Step 6: Production Optimization
```bash
# Cache for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

## 🔧 Common Issues & Solutions

### Issue 1: Missing APP_KEY
**Symptoms:** "No application encryption key has been specified"
```bash
php artisan key:generate
```

### Issue 2: Database Connection Failed
**Symptoms:** "SQLSTATE[HY000] [2002] Connection refused"
- Check database credentials in `.env`
- Verify database server is running
- Test connection from hosting control panel

### Issue 3: Missing PHP Extensions
**Symptoms:** "Class 'Extension' not found"
```bash
# Check required extensions
php -m | grep -E "pdo|mysql|mbstring|openssl|tokenizer|xml|ctype|json"
```

### Issue 4: Memory Limit Exceeded
**Symptoms:** "Fatal error: Allowed memory size exhausted"
- Increase `memory_limit` in `php.ini`
- Or add to `.htaccess`: `php_value memory_limit 256M`

### Issue 5: File Permission Issues
**Symptoms:** "Permission denied" or "failed to open stream"
```bash
# Fix storage and cache permissions
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### Issue 6: Route Not Found
**Symptoms:** Specific to `/profil` route
```bash
# Check if route exists
php artisan route:list | grep profil

# Clear route cache
php artisan route:clear
php artisan route:cache
```

## 📋 Production Checklist

- [ ] `.env` file exists and configured
- [ ] `APP_KEY` is generated
- [ ] `APP_ENV=production`
- [ ] `APP_DEBUG=false`
- [ ] Database connection working
- [ ] All migrations run
- [ ] File permissions correct (755/644)
- [ ] Storage writable (775)
- [ ] Composer dependencies installed
- [ ] Caches cleared and regenerated
- [ ] PHP version compatible (8.2+)
- [ ] Required PHP extensions installed

## 🚀 Deployment Commands

```bash
# Complete deployment sequence
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
```

## 📞 Emergency Contacts

**If all else fails:**
1. Contact hosting provider support
2. Check hosting control panel error logs
3. Verify PHP version and extensions
4. Check disk space and memory limits
5. Review server configuration

## 📝 Log Analysis

**Look for these patterns in logs:**
- `Fatal error:`
- `SQLSTATE:`
- `Class not found:`
- `Permission denied:`
- `Memory exhausted:`
- `Connection refused:`

**Common Laravel errors:**
- `Unauthenticated` - Session/auth issues
- `TokenMismatchException` - CSRF token issues
- `QueryException` - Database query problems
- `FatalErrorException` - PHP fatal errors

---

**Last Updated:** $(date)  
**Status:** Active troubleshooting for kecamatangwaesama.id/profil