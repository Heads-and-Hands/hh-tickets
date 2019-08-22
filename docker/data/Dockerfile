FROM alpine:3.7
# Добавим для бекапов
RUN apk add --no-cache \
    bash \
    zip
# Добавляем PHP-исходники нашего веб приложения
ADD app /app
# Даем права на файлы для сервера
RUN chmod -R 777 /app/backend/runtime
RUN chmod -R 777 /app/backend/files
# Добавляем скрипт чтобы контейнер всегда работал и не выключался
COPY docker/data/docker-entrypoint.sh /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]