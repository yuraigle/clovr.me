php artisan clear-compiled &&
php artisan optimize:clear --no-ansi &&
php artisan icons:cache --no-ansi &&
php artisan config:cache --no-ansi &&
php artisan route:cache --no-ansi &&
php artisan view:cache --no-ansi &&
composer dump-autoload --optimize &&
chown -R orlov:www-data ./storage/framework/views/
