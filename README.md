<p align="center">
    <h1 align="center">Tickets</h1>
    <br>
</p>

<p>Инструкция по установке</p>

1. Создаем корневую директорию для проекта и заходим в нее

       mkdir project-dir && cd project-dir
2. Скачиваем проект в текущую директорию

       git clone https://github.com/Heads-and-Hands/hh-tickets.git .
3. Инициализируем проект

       php init --env=Development --overwrite=All
4. Подтягиваем зависимости

       composer install
5. Запускаем окружение

       docker-compose -f docker/docker-compose.yml up -d
6. Открываем в редакторе файл common/config/main-local.php и заполняем его даными для подключения к БД
7. Подключаемся к контейнеру
       
       docker exec -it tickets_fpm bash
8. Выполняем команду миграции БД

       php yii migrate
9. Создаем таблицы для RBAC

       php yii migrate --migrationPath=@yii/rbac/migrations
10. Добавляем роли и разрешения

        php yii rbac/init       
11. Выходим из контейнера

        CTRL+D 
12. Останавливаем работу сервиса

        docker-compose -f docker/docker-compose.yml down
13. Запускаем его заново

        docker-compose docker/docker-compose up -d
14. Проверяем, набрав адрес в браузере

        http://localhost:28587/admin 