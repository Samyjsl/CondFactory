# Название проекта
Веб-приложение "Кондитерская фабрика", разработанное с использованием PHP (бэкенд), HTML/CSS/JavaScript (фронтенд), с возможностью запуска через Docker.

## 📦 Используемые технологии

- PHP 8.x
- HTML5 / CSS3
- JavaScript (Vanilla JS)
- Docker / Docker Compose
- Apache
- MySQL

## Этапы по запуску и остановке проекта

1. Клонируй проект:
```bash
git clone https://github.com/username/project.git
cd project

2. Запустите проект
docker compose -f compose.yaml up --build

3. Откройте в браузере
Приложение: http://localhost:8080
phpMyAdmin: http://localhost:8081

4. Настройте MySQL, испортируйте базу данных с помощью файла MSQ.

5. Остановите проект
docker compose down

Структура проекта
project/
├── src/           # Веб-код (php/, js/, css/)
├── php/           # Dockerfile и настройки PHP
├── .env           # Настройки MySQL, phpMyAdmin
├── compose.yaml   # Docker Compose конфигурация
└── README.md
