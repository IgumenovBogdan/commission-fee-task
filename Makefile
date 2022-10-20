build:
	docker-compose up -d --build
	docker-compose run --rm php-cli composer install

up:
	docker-compose up -d

down:
	docker-compose down

calculate:
	docker-compose exec php-fpm php artisan commissions:calculate input.csv

test:
	docker-compose exec php-fpm php artisan test
