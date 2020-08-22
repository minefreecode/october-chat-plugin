# Chat plugin for the popular October CMS using websockets (без других сторонних ресурсов)
Чат интегририруется с вашими существующими аккаунтами пользователей  `"october/rain"` автоматически. Напомню что данный плагин
часто импользуется с `october`-шаблоном автоматом. При этом в вашей БД CMS должна быть таблица `users`. Поле `avatar` с картинками
в `users` вы должны добавить сами

## Usage
Add folder `alekseypavlov` to `plugins` as `plugins/alekseypavlov`

Выполните
`php artisan plugin:refresh alekseypavlov.chat`
При этом автоматом создается таблица в БД
``
chat_messages(id, text, user_id, created_at, updated_at);
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

## Как применить автар ваших аккаунтов October
Данный плагин работает с вашими аккаунтами October автоматом. Чтобы применить аватары ваших аккунтов пользователя
необходимо чтобы в таблицах `users` имелось поле для хранения автара, например, `avatar`. В случае наличия такого поля
можно смело добавить в шаблон `plugins\alekseypavlov\chat\components\messages\default.htm` вместо
`<img src="{{ '/plugins/alekseypavlov/chat/assets/images/unnamed.png'|app }}" alt="avatar" />` такую запись
`<img src="{{ message.user.avatar }}" alt="avatar" />`
