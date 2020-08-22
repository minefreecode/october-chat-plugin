# Chat plugin for the popular October CMS using websockets

## Usage

### Server start

shell
php artisan chat-server: run
``,

You can specify the port `--port` if you like, the default is` 8080`.

### Attach component

Add component to your page / template.
You can set the `uri` property if running on a different port.
The default is `ws: // localhost: 8080 /`.

,,, ini
[chat]
==
{% component messages%}
``,

## If you need improvement, write to Telegram
Telegram - @ programmer36
