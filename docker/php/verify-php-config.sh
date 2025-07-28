#!/bin/bash

echo "Verifying PHP configuration..."

# Check if custom.ini is loaded
echo "=== PHP Configuration Files ==="
php --ini

echo ""
echo "=== Current PHP Settings ==="
echo "Memory Limit: $(php -r 'echo ini_get("memory_limit");')"
echo "Upload Max Filesize: $(php -r 'echo ini_get("upload_max_filesize");')"
echo "Post Max Size: $(php -r 'echo ini_get("post_max_size");')"
echo "Max Execution Time: $(php -r 'echo ini_get("max_execution_time");')"
echo "Error Reporting: $(php -r 'echo ini_get("error_reporting");')"
echo "Display Errors: $(php -r 'echo ini_get("display_errors");')"

echo ""
echo "=== PHP-FPM Configuration ==="
php-fpm -t 