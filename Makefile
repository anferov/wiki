# поднимаем контейнеры
.PHONY: up
up:
	docker-compose up -d

# удаляем контейнеры
.PHONY: down
down:
	docker-compose down

# останавливем контейнеры
.PHONY: stop
stop:
	docker-compose stop

# проверить
.PHONY: build
build:
	docker-compose --build

.PHONY: vendor
vendor:
	docker-compose exec -T php-fpm bash -c "COMPOSER_MEMORY_LIMIT=-1 composer install --prefer-dist --no-scripts --no-interaction -v"

# make vendor-add PACK="easycorp/easyadmin-bundle"
.PHONY: vendor-add
vendor-add:
	docker-compose exec -T php-fpm bash -c "composer require $(PACK)"

# make vendor-add PACK="easycorp/easyadmin-bundle"
.PHONY: vendor-dev
vendor-dev:
	docker-compose exec -T php-fpm bash -c "composer require --dev $(PACK)"

.PHONY: logs
logs:
	docker-compose logs -f

.PHONY: m
m:
	docker-compose exec -T php-fpm bash -c "php bin/console make$(E)"

.PHONY: optimize
optimize:
	docker-compose exec -T php-fpm bash -c "composer dump-autoload -o --apcu --classmap-authoritative"
