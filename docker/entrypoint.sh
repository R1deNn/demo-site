#!/bin/bash
set -e

# Генерируем .env из переменных окружения Docker Compose.
# Хостовый .env (с sqlite) монтируется через bind mount и перебивает env vars в Laravel,
# поэтому перезаписываем его правильными значениями на старте контейнера.
cat > /var/www/html/.env <<EOF
APP_NAME=${APP_NAME:-Laravel}
APP_ENV=${APP_ENV:-local}
APP_KEY=${APP_KEY}
APP_DEBUG=${APP_DEBUG:-true}
APP_URL=${APP_URL:-http://localhost:8000}

LOG_CHANNEL=stack
LOG_LEVEL=debug

DB_CONNECTION=${DB_CONNECTION:-pgsql}
DB_HOST=${DB_HOST:-postgres}
DB_PORT=${DB_PORT:-5432}
DB_DATABASE=${DB_DATABASE:-laravel}
DB_USERNAME=${DB_USERNAME:-laravel}
DB_PASSWORD=${DB_PASSWORD:-secret}

SESSION_DRIVER=${SESSION_DRIVER:-database}
SESSION_LIFETIME=120

CACHE_STORE=${CACHE_STORE:-database}
QUEUE_CONNECTION=${QUEUE_CONNECTION:-database}
EOF

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

echo "[entrypoint] Запускаем миграции и сид (пересоздаём таблицы при каждом старте)..."
php artisan migrate:fresh --seed --force

echo "[entrypoint] Запускаем встроенный сервер Laravel..."
# exec заменяет текущий shell-процесс на artisan,
# чтобы Docker корректно обрабатывал сигналы (SIGTERM при остановке контейнера)
exec php artisan serve --host=0.0.0.0 --port=8000
