FROM bitnami/laravel:latest

COPY ./ /app
WORKDIR /app
RUN composer install
RUN php artisan key:generate
RUN php artisan l5-swagger:generate