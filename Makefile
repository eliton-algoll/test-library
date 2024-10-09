APP_SERVICE=app
DB_SERVICE=mysql
WEB_SERVER=webserver
EXEC_DOCKER ?= docker-compose exec $(APP_SERVICE)

install:
	docker-compose up -d --build

up:
	docker-compose up -d

test:
	$(EXEC_DOCKER) vendor/bin/phpunit

down:
	docker-compose down

artisan:
	$(EXEC_DOCKER) php artisan $(filter-out $@,$(MAKECMDGOALS))

migrate:
	$(EXEC_DOCKER) php artisan migrate

migrate-rollback:
	$(EXEC_DOCKER) php artisan migrate:rollback

seed:
	$(EXEC_DOCKER) php artisan artisan db:seed

clear:
	$(EXEC_DOCKER) php artisan cache:clear
	$(EXEC_DOCKER) php artisan config:clear
	$(EXEC_DOCKER) php artisan route:clear
	$(EXEC_DOCKER) php artisan view:clear

clean:
	docker-compose down
