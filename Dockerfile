# Базовый образ: официальный PHP 8.3 CLI на Debian Bookworm (slim)
# Используем CLI (не FPM), так как запускаем встроенный сервер: php artisan serve
FROM php:8.4-cli-bookworm

# Системные зависимости:
# - libpq-dev — нужна для компиляции pdo_pgsql (PostgreSQL-драйвер)
# - unzip, git — нужны Composer для установки зависимостей
RUN apt-get update && apt-get install -y --no-install-recommends \
        libpq-dev \
        unzip \
        git \
    && docker-php-ext-install pdo pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

# Копируем Composer из официального образа (без установки через apt)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Сначала копируем только файлы зависимостей — слой кэшируется,
# пока composer.json не меняется. Ускоряет пересборку при изменении кода.
COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-scripts \
    --no-interaction

# Копируем остальной исходный код
COPY . .

# Права на storage и bootstrap/cache — PHP-процесс должен писать в них
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Копируем entrypoint-скрипт и делаем его исполняемым
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 8000

ENTRYPOINT ["entrypoint.sh"]
