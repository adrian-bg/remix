#!/bin/sh

build() {
  docker-compose up --build -d
}

init() {
  docker-compose exec authenticator composer install
  docker-compose exec authenticator cp .env.example .env
  docker-compose exec authenticator cp .env.testing.example .env.testing
  docker-compose exec authenticator php artisan key:generate
  docker-compose exec authenticator php artisan key:generate --env=testing
  docker-compose exec authenticator php artisan migrate
  docker-compose exec authenticator php artisan passport:install
  docker-compose exec authenticator php artisan migrate
  docker-compose exec authenticator npm ci
  docker-compose exec authenticator npm run build

  docker-compose exec wallet1 composer install
  docker-compose exec wallet1 cp .env.example .env
  docker-compose exec wallet1 cp .env.testing.example .env.testing
  docker-compose exec wallet1 php artisan key:generate
  docker-compose exec wallet1 php artisan key:generate --env=testing
  docker-compose exec wallet1 php artisan migrate
  docker-compose exec wallet1 npm ci
  docker-compose exec wallet1 npm run build

  docker-compose exec payment_processor composer install
  docker-compose exec payment_processor cp .env.example .env
  docker-compose exec payment_processor php artisan key:generate
  docker-compose exec payment_processor php artisan key:generate --env=testing
  docker-compose exec payment_processor php artisan migrate
  docker-compose exec payment_processor npm ci
  docker-compose exec payment_processor npm run build
  docker-compose exec -T payment_processor php artisan queue:work --daemon &
}

start() {
  docker-compose up -d
}

stop() {
  docker-compose down
}

if [ "$1" = "build" ]
then
  build
elif [ "$1" = "init" ]
then
  init
elif [ "$1" = "start" ]
then
  start
elif [ "$1" = "stop" ]
then
  stop
elif [ "$1" = "test" ]
then
  start
  docker-compose exec authenticator php artisan test
fi