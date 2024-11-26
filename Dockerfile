FROM bitnami/laravel:latest

COPY ./api /app
WORKDIR /app
RUN composer install
RUN php artisan l5-swagger:generate