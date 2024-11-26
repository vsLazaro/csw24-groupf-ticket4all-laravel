FROM 102183358164.dkr.ecr.us-east-1.amazonaws.com/trab2-construcao:latest

ARG APP_KEY

COPY ./api /app
WORKDIR /app
RUN composer install
RUN php artisan l5-swagger:generate