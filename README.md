# Плагин чата для популярной CMS October с использованием веб-сокетов

## Использование

### Запуск сервера

```shell
php artisan websockets:run
```

Можно указать порт `--port` если хотите, по умолчанию `8080`.

### Прикрепите компонент

Добавьте компонент на вашу страницу/шаблон.
Вы можете поставит свойство `uri` если запускаете с другим портом.
По умолчанию `ws://localhost:8080/`.

```ini
[websocket]
==
{% component messages %}
```



**You are ready to rock on sockets. Build a chat app!**

Don't forget to add [jQuery](http://jquery.com/) and `{% scripts %}` placeholder.
```html
url = "websockets"
[websocket]
==
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Web Sockets</title>
    </head>
    <body>
        <ul data-websocket-onmessage="$(this).append('<li>'+event.payload.text+'</li>')"></ul>

        <form role="form" data-websocket-event="message">
            <input type="text" name="text">
            <button type="submit">Send</button>
        </form>

        <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
        {% scripts %}
    </body>
</html>
```


