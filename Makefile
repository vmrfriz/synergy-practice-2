.PHONY: help install up down restart rebuild

# Команда по умолчанию (выводит список доступных команд)
help:
	@echo "Доступные команды:"
	@echo "  make install - запуск проекта с нуля"
	@echo "  make up - запуск Docker контейнеров"
	@echo "  make down - остановка Docker контейнеров"
	@echo "  make restart - перезапуск Docker контейнеров"
	@echo "  make rebuild - пересборка Docker контейнеров"

# Полная инициализация проекта с нуля
install: copy-env composer-install up sail-composer-install npm-build db-migrate

# Запуск контейнеров в фоновом режиме
up:
	vendor/bin/sail up -d

# Остановить контейнеры
down:
	vendor/bin/sail down

# Перезапуск контейнеров
restart:
	vendor/bin/sail restart

# Сборка Docker-образов
rebuild: down
	sail build --no-cache
	sail up -d

# Убедиться, что .env существует
copy-env:
	cp -n .env.example .env

# Первоначальная установка зависимостей composer
composer-install:
	docker run --rm -u "$(id -u):$(id -g)" -v ".:/app" -w "/app" composer:latest install --ignore-platform-reqs

# Установка зависимостей composer через окружение рабочее окружение
sail-composer-install:
	vendor/bin/sail composer install

# Сборка фронтэнда
npm-build:
	vendor/bin/sail npm run build

# Запуск миграций и сидеров
db-migrate:
	vendor/bin/sail artisan migrate:fresh --seed
