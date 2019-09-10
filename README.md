<p align="center">
    <h1 align="center">Tickets</h1>
    <br>
</p>

<p>Инструкция по установке</p>

1. Создаем корневую директорию для проекта и заходим в нее

       mkdir project-dir && cd project-dir
2. Скачиваем проект в текущую директорию

       git clone https://github.com/Heads-and-Hands/hh-tickets.git .
3. Запускаем окружение

       docker-compose docker/docker-compose up -d
4. Открываем в редакторе файл app/common/config/main-local.php и заполняем его даными для подключения к БД
5. Подключаемся к контейнеру
       
       docker exec -it docker_fpm bash
6. Выполняем команду миграции БД

       php yii migrate
7. Выходим из контейнера - для выхода используем комбинацию клавиш:

       CTRL+D 
8. Останавливаем работу сервиса

       docker-compose -f docker/docker-compose.yml down
9. Запускаем его заново

       docker-compose docker/docker-compose up -d
10. Проверяем, набрав адрес в браузере

        http://localhost:28587/admin 