FROM nginx

# Создаем папку для логов
RUN mkdir -p /var/www/log

# Добавляем наш конфиг
ADD docker/nginx/conf/default.conf /etc/nginx/conf.d/default.conf
CMD /bin/bash -c "exec nginx -g 'daemon off;'"