#!make
include .env
export $(shell sed 's/=.*//' .env)
RED='\033[0;31m'        #  ${RED}
GREEN='\033[0;32m'      #  ${GREEN}
BOLD='\033[1;m'			#  ${BOLD}
WARNING=\033[37;1;41m	#  ${WARNING}
END_COLOR='\033[0m'		#  ${END_COLOR}

.PHONY: rebuild up clone stop restart status console-php console-nginx clean help

docker-env: nginx-config rebuild up composer-install

dialog:
	@bash ./sh-dialog.sh

nginx-config:
	@bash ./sh-config-nginx.sh

rebuild: stop
	@echo "\n\033[1;m Rebuilding containers... \033[0m"
	@docker-compose build --no-cache

clone:
	@echo "\n\033[1;m Cloning App (${BRANCH_NAME} branch) \033[0m"
	@if cd ${APP_FOLDER} 2> /dev/null; then git pull; else git clone -b ${BRANCH_NAME} ${GIT_URL} ${APP_FOLDER}; fi

up:
	@echo "\n\033[1;m Spinning up containers for ${ENVIRONMENT} environment... \033[0m"
	@docker-compose -p ${COMPOSE_PROJECT_NAME} up -d
	@$(MAKE) --no-print-directory status

hosts:
	@echo "\n\033[1;m Adding record in to your local hosts file.\033[0m"
	@echo "\n\033[1;m Please use your local sudo password.\033[0m"
	@echo "127.0.0.1 ${APP_NAME}.${ENVIRONMENT}.loc" | sudo tee -a /etc/hosts

stop:
	@echo "\n\033[1;m Halting containers... \033[0m"
	@docker-compose stop

restart:
	@echo "\n\033[1;m Restarting containers... \033[0m"
	@docker-compose stop
	@docker-compose up -d
	@$(MAKE) --no-print-directory status

cache-clear:
	@docker-compose exec php bash -c "cd /var/www/html/${APP_NAME}/ && php bin/console cache:clear --env=prod"

status:
	@echo "\n\033[1;m Containers statuses \033[0m"
	@docker-compose ps

clean:
	@echo "\033[1;31m\033[5m *** Removing containers and Application! ***\033[0m"
	@echo "\033[1;31m\033[5m *** Ensure that you commited changes!*** \033[0m"
	@$(MAKE) --no-print-directory dialog
	@docker-compose down --rmi all 2> /dev/null
	@rm -rf ./.data/
	@rm -rf ./.logs/
	@rm -rf ./${APP_FOLDER}/
	@$(MAKE) --no-print-directory status

console-php:
	@docker-compose exec php bash

console-nginx:
	@docker-compose exec nginx bash

phpunit-run:
	@docker-compose exec -T php bash -c "cd /var/www/html/${APP_NAME}/vendor/bin && php phpunit ../../tests/"

composer-install:
	@docker-compose exec -T php bash -c "cd /var/www/html/${APP_NAME}/ && composer install && composer dump-autoload -o"
	@docker-compose exec -T php bash -c "chown www-data:www-data -R /var/www/html/${APP_NAME}/var/"
	@docker-compose exec -T php bash -c "chmod 755 -R  /var/www/html/${APP_NAME}/var/"

composer-dump-autoload:
	@docker-compose exec php bash -c "cd /var/www/html/${APP_NAME}/ && composer dump-autoload"
	@docker-compose exec php bash -c "chown www-data:www-data -R /var/www/html/${APP_NAME}/var/"
	@docker-compose exec php bash -c "chmod 755 -R  /var/www/html/${APP_NAME}/var/"

logs-nginx:
	@docker-compose logs --tail=100 -f nginx
logs-php:
	@docker-compose logs --tail=100 -f php

help:
	@echo "\033[1;32mdocker-env\t\t- Main scenario, used by default\033[0m"

	@echo "\n\033[1mMain section\033[0m"
	@echo "clone\t\t\t- clone Application repo (remove old Application)"
	@echo "rebuild\t\t\t- build containers w/o cache"
	@echo "up\t\t\t- start project"
	@echo "stop\t\t\t- stop project"
	@echo "restart\t\t\t- restart containers"
	@echo "status\t\t\t- show status of containers"
	@echo "nginx-config\t\t- generates nginx config file based on .env parameters"
	@echo "composer-install\t- install dependencies via composer"
	@echo "composer-dump-autoload\t- refresh dependencies via composer"

	@echo "\n\033[1;31m\033[5mclean\t\t\t- Reset project. All Local application data will be lost!\033[0m"

	@echo "\n\033[1mConsole section\033[0m"
	@echo "console-app\t\t- run bash console for dev application container"
	@echo "console-nginx\t\t- run bash console for web server container"

	@echo "\nphpunit-run\t\t- run phpunit tests"

	@echo "\n\033[1mLogs section\033[0m"
	@echo "logs-nginx\t\t- show web server logs"
	@echo "logs-db\t\t\t- show database logs"
	@echo "logs-app\t\t- show application dev logs"
	@echo "\n\033[0;33mhelp\t\t\t- show this menu\033[0m"
