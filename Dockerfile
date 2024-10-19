FROM bitnami/laravel:latest

COPY ./ /app
RUN composer install
RUN php artisan key:generate