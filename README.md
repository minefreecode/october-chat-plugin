# Chat plugin for the popular October CMS using websockets (no other third-party resources)
The chat will integrate with your existing "october/rain" user accounts automatically. Let me remind you that this plugin
often used with the automaton `october` CMS. In this case, your CMS database must have a `users` table. The `avatar` field with pictures
in `users` you must add yourself

## Usage
Add folder `alekseypavlov` to` plugins` as `plugins/alekseypavlov`

Execute
`php artisan plugin:refresh alekseypavlov.chat`
In this case, a table is automatically created in the database
``
chat_messages (id, text, user_id, created_at, updated_at);
``

### Server start

Shell
``
php artisan chat-server:run
``

You can specify the port `--port` if you like, the default is `8080`.

Shell
``
php artisan chat-server:run --port=8081
``,

### Attach component

Add component to your page / template.
You can set the `uri` property if running on a different port.
The default is `ws://localhost:8080/`.

``ini
[chat]
==
{% component messages %}
``

## Possible mistakes:
1. The port is busy. To see which port is being used use the Linux command `sudo lsof -i -P -n | grep LISTEN`
2. The server and web socket service must be running on the same port. This is done in different terminal consoles.
``
php7.2 artisan serve
php7.2 artisan chat-server:run --port=8081
``

## Adding Styles
You can change the styles for the component yourself.
Styles for the component are added in the file `plugins\alekseypavlov\chat\assets\css\chat.css`

## How to change the look
You can change the appearance template yourself.
Editing of the general chat template occurs in the file `plugins\alekseypavlov\chat\components\messages\default.htm`.
List items are edited in the file `plugins\alekseypavlov\chat\components\messages\message_view.htm`.



## How to apply autara to your October accounts
This plugin works with your October accounts automatically. To apply the avatars of your user accounts
it is necessary that the `users` tables have a field for storing the avatar, for example,`avatar`. If there is such a field
you can safely add to the template `plugins\alekseypavlov\chat\components\messages\message_view.htm` instead
`<img src="{{ '/plugins/alekseypavlov/chat/assets/images/unnamed.png'|app }}" alt="avatar" />` such an entry
`<img src="{{ message.user.avatar }}" alt="avatar" />`
