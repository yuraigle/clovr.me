composer update --no-ansi &&
composer install --optimize-autoloader --no-dev --no-ansi &&
php artisan optimize:clear --no-ansi &&
php artisan icons:cache --no-ansi &&
php artisan config:cache --no-ansi &&
php artisan route:cache --no-ansi &&
php artisan view:cache --no-ansi &&
chown -R orlov:www-data ./storage/framework/views/
