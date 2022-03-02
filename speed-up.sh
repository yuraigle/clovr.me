composer install --optimize-autoloader --no-dev &&
php artisan cache:clear &&
php artisan config:cache &&
php artisan route:cache &&
php artisan view:cache &&
chown -R orlov:www-data ./storage/framework/views/
