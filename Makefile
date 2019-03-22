
.SILENT:

console = console

d = docker
dc = docker-compose

####################################################
#Команды

exec = $(d) exec

ssh_command = $(exec) -it

build_command = $(dc) build --force-recreate

ssh_to_console_command = $(ssh_command) $(console) bash

####################################################
#Запуск контейнера
build:
	$(build_command)

####################################################
#Вход в контейнеры
ssh_to_console:
	$(ssh_to_console_command)

####################################################
#Работа с контейнерами
#Установка
prod:
	$(d) network prune -f
	$(build_command)
	chmod +x console phpunit

####################################################
#Работа с контейнерами
#Установка для разработки
dev:
	$(d) network prune -f
	CURRENT_UID=`id -u` CURRENT_GID=`id -g` CURRENT_USERNAME=`id -u -n` $(dc) -f docker-compose.yml -f docker-compose.dev.yml up -d --build --force-recreate
	chmod +x console phpunit

####################################################
