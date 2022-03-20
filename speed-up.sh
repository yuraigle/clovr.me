composer update --no-ansi &&
composer install --optimize-autoloader --no-dev --no-ansi &&
php artisan cache:clear &&
php artisan config:cache &&
php artisan route:cache &&
php artisan view:cache &&
chown -R orlov:www-data ./storage/framework/views/
