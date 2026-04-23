#!/bin/bash
set -e

echo "[entrypoint] Ждём PostgreSQL на ${DB_HOST}:${DB_PORT}..."

# Ждём доступности PostgreSQL через PDO (без netcat/wait-for-it.sh)
until php -r "
    try {
        \$dsn = 'pgsql:host=${DB_HOST};port=${DB_PORT};dbname=${DB_DATABASE}';
        new PDO(\$dsn, '${DB_USERNAME}', '${DB_PASSWORD}');
        echo 'ok';
    } catch (Exception \$e) {
        exit(1);
    }
" 2>/dev/null | grep -q ok; do
    echo "[entrypoint] Postgres не готов, повторяем через 2 сек..."
    sleep 2
done

echo "[entrypoint] PostgreSQL готов."

echo "[entrypoint] Запускаем миграции..."
php artisan migrate --force

echo "[entrypoint] Заполняем базу данными..."
php artisan db:seed --force

echo "[entrypoint] Запускаем встроенный сервер Laravel..."
# exec заменяет текущий shell-процесс на artisan,
# чтобы Docker корректно обрабатывал сигналы (SIGTERM при остановке контейнера)
exec php artisan serve --host=0.0.0.0 --port=8000
