#!/bin/bash

# Application Monitoring Script for Kantor Camat Waesama
# This script monitors application health and sends alerts if needed

# Configuration
APP_NAME="Kantor Camat Waesama"
APP_URL="https://your-domain.com"
LOG_FILE="/var/log/kantor-camat-monitor.log"
ALERT_EMAIL="admin@your-domain.com"
MAX_RESPONSE_TIME=5  # seconds
MAX_LOAD_AVERAGE=2.0
MAX_DISK_USAGE=85    # percentage
MAX_MEMORY_USAGE=80  # percentage

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Functions
log_message() {
    echo "$(date '+%Y-%m-%d %H:%M:%S') - $1" | tee -a "$LOG_FILE"
}

print_status() {
    echo -e "${BLUE}[INFO]${NC} $1"
    log_message "[INFO] $1"
}

print_success() {
    echo -e "${GREEN}[OK]${NC} $1"
    log_message "[OK] $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
    log_message "[WARNING] $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
    log_message "[ERROR] $1"
}

send_alert() {
    local subject="$1"
    local message="$2"
    
    # Send email alert (requires mail command)
    if command -v mail &> /dev/null; then
        echo "$message" | mail -s "$subject" "$ALERT_EMAIL"
        print_status "Alert sent to $ALERT_EMAIL"
    else
        print_warning "Mail command not available. Alert not sent."
    fi
}

# Start monitoring
print_status "Starting application monitoring for $APP_NAME"
echo "==========================================="

# Check if application is accessible
print_status "Checking application accessibility..."
response_time=$(curl -o /dev/null -s -w '%{time_total}' "$APP_URL" || echo "999")
http_code=$(curl -o /dev/null -s -w '%{http_code}' "$APP_URL" || echo "000")

if [ "$http_code" = "200" ]; then
    if (( $(echo "$response_time <= $MAX_RESPONSE_TIME" | bc -l) )); then
        print_success "Application is accessible (${response_time}s response time)"
    else
        print_warning "Application is slow (${response_time}s response time)"
        send_alert "$APP_NAME - Slow Response" "Application response time is ${response_time}s (threshold: ${MAX_RESPONSE_TIME}s)"
    fi
else
    print_error "Application is not accessible (HTTP $http_code)"
    send_alert "$APP_NAME - Application Down" "Application returned HTTP $http_code. Please check immediately."
fi

# Check database connectivity
print_status "Checking database connectivity..."
if [ -f .env ]; then
    export $(cat .env | grep -v '^#' | xargs)
    
    if php artisan tinker --execute="DB::connection()->getPdo(); echo 'Database OK';" 2>/dev/null | grep -q "Database OK"; then
        print_success "Database connection is working"
    else
        print_error "Database connection failed"
        send_alert "$APP_NAME - Database Error" "Database connection failed. Please check database server."
    fi
else
    print_error ".env file not found"
fi

# Check disk usage
print_status "Checking disk usage..."
disk_usage=$(df / | awk 'NR==2 {print $5}' | sed 's/%//')
if [ "$disk_usage" -gt "$MAX_DISK_USAGE" ]; then
    print_error "Disk usage is high: ${disk_usage}%"
    send_alert "$APP_NAME - High Disk Usage" "Disk usage is ${disk_usage}% (threshold: ${MAX_DISK_USAGE}%)"
else
    print_success "Disk usage is normal: ${disk_usage}%"
fi

# Check memory usage
print_status "Checking memory usage..."
memory_usage=$(free | awk 'NR==2{printf "%.0f", $3*100/$2 }')
if [ "$memory_usage" -gt "$MAX_MEMORY_USAGE" ]; then
    print_error "Memory usage is high: ${memory_usage}%"
    send_alert "$APP_NAME - High Memory Usage" "Memory usage is ${memory_usage}% (threshold: ${MAX_MEMORY_USAGE}%)"
else
    print_success "Memory usage is normal: ${memory_usage}%"
fi

# Check system load
print_status "Checking system load..."
load_average=$(uptime | awk -F'load average:' '{print $2}' | awk '{print $1}' | sed 's/,//')
if (( $(echo "$load_average > $MAX_LOAD_AVERAGE" | bc -l) )); then
    print_error "System load is high: $load_average"
    send_alert "$APP_NAME - High System Load" "System load average is $load_average (threshold: $MAX_LOAD_AVERAGE)"
else
    print_success "System load is normal: $load_average"
fi

# Check Laravel logs for errors
print_status "Checking Laravel logs for recent errors..."
if [ -f "storage/logs/laravel.log" ]; then
    error_count=$(tail -n 100 storage/logs/laravel.log | grep -c "ERROR" || echo "0")
    if [ "$error_count" -gt "0" ]; then
        print_warning "Found $error_count recent errors in Laravel logs"
        recent_errors=$(tail -n 100 storage/logs/laravel.log | grep "ERROR" | tail -n 5)
        send_alert "$APP_NAME - Laravel Errors" "Found $error_count recent errors:\n\n$recent_errors"
    else
        print_success "No recent errors in Laravel logs"
    fi
else
    print_warning "Laravel log file not found"
fi

# Check queue workers (if using queues)
print_status "Checking queue workers..."
queue_workers=$(ps aux | grep "queue:work" | grep -v grep | wc -l)
if [ "$queue_workers" -gt "0" ]; then
    print_success "Queue workers are running ($queue_workers active)"
else
    print_warning "No queue workers found running"
fi

# Check storage permissions
print_status "Checking storage permissions..."
if [ -w "storage" ] && [ -w "bootstrap/cache" ]; then
    print_success "Storage directories are writable"
else
    print_error "Storage directories are not writable"
    send_alert "$APP_NAME - Permission Error" "Storage directories are not writable. Please check file permissions."
fi

# Check SSL certificate (if HTTPS)
if [[ "$APP_URL" == https* ]]; then
    print_status "Checking SSL certificate..."
    domain=$(echo "$APP_URL" | sed 's|https://||' | sed 's|/.*||')
    ssl_expiry=$(echo | openssl s_client -servername "$domain" -connect "$domain:443" 2>/dev/null | openssl x509 -noout -dates | grep notAfter | cut -d= -f2)
    ssl_expiry_epoch=$(date -d "$ssl_expiry" +%s 2>/dev/null || echo "0")
    current_epoch=$(date +%s)
    days_until_expiry=$(( (ssl_expiry_epoch - current_epoch) / 86400 ))
    
    if [ "$days_until_expiry" -lt "30" ] && [ "$days_until_expiry" -gt "0" ]; then
        print_warning "SSL certificate expires in $days_until_expiry days"
        send_alert "$APP_NAME - SSL Certificate Expiring" "SSL certificate for $domain expires in $days_until_expiry days."
    elif [ "$days_until_expiry" -le "0" ]; then
        print_error "SSL certificate has expired"
        send_alert "$APP_NAME - SSL Certificate Expired" "SSL certificate for $domain has expired."
    else
        print_success "SSL certificate is valid ($days_until_expiry days remaining)"
    fi
fi

# Summary
echo "==========================================="
print_status "Monitoring completed at $(date)"
echo ""
echo "📊 System Status Summary:"
echo "   🌐 Application: $([[ "$http_code" == "200" ]] && echo "✅ Online" || echo "❌ Offline")"
echo "   🗄️ Database: $(php artisan tinker --execute="DB::connection()->getPdo(); echo 'OK';" 2>/dev/null | grep -q "OK" && echo "✅ Connected" || echo "❌ Error")"
echo "   💾 Disk Usage: ${disk_usage}%"
echo "   🧠 Memory Usage: ${memory_usage}%"
echo "   ⚡ System Load: $load_average"
echo "   📝 Recent Errors: $error_count"
echo "   🔄 Queue Workers: $queue_workers"
echo ""
print_success "Monitoring script completed!"