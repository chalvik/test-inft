USER_ID := $(shell id -u)
GROUP_ID := $(shell id -g)

build:
	docker compose up --build
up:
	docker compose up -d
down:
	docker compose down
php-bash:
	docker compose exec php-infotech bash
vendor:
	docker run -it --rm  --interactive --tty -v .:/app --user $(USER_ID):$(GROUP_ID) composer composer install --ignore-platform-reqs
