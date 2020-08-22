# Chat plugin for the popular October CMS using websockets

## Usage
Add folder `alekseypavlov` to `plugins` as `plugins/alekseypavlov`

Выполните
`php artisan plugin:refresh alekseypavlov.chat`
При этом автоматом создается таблица в БД
``
chat_messages;
+------------+------------------+------+-----+---------+----------------+
| Field      | Type             | Null | Key | Default | Extra          |
+------------+------------------+------+-----+---------+----------------+
| id         | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
| text       | varchar(255)     | NO   |     | NULL    |                |
| user_id    | int(10) unsigned | NO   | MUL | NULL    |                |
| created_at | timestamp        | YES  |     | NULL    |                |
| updated_at | timestamp        | YES  |     | NULL    |                |
+------------+------------------+------+-----+---------+----------------+
``

### Server start

```shell
php artisan chat-server:run
```

You can specify the port `--port` if you like, the default is` 8080`.

```shell
php artisan chat-server:run --port=8081
```

### Attach component

Add component to your page / template.
You can set the `uri` property if running on a different port.
The default is `ws://localhost:8080/`.

```ini
[chat]
==
{% component messages %}
```

## Возможные ошибки:
1. Порт занят. Для просмотра какой порт используется используйте команду линукс `sudo lsof -i -P -n | grep LISTEN`
2. Сервер и сервис веб-сокетов должны быть запущены на одном порту. Делается это в разных консолях терминала
``
php7.2 artisan serve
php7.2 artisan chat-server:run --port=8081
``

## Добавление стилей
Вы можете сами менять стили для компонента.
Добавление стилей для компонента происходит в файле `plugins\alekseypavlov\chat\assets\css\chat.css`

## Как поменять внешний вид
Вы можете сами менять шаблон внешнего вида.
Редактирование шаблона врешнего вида происходит в файле `plugins\alekseypavlov\chat\components\messages\default.htm`.
