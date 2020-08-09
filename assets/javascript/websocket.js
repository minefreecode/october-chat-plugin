if (window.jQuery === undefined)
    throw new Error('Библиотека JQuery не загружена. Веб-сокеты не могут быть инициализированы.');

if (window.WebSocket === undefined)
    throw new Error('Ваш праузер не поддерживает API вебсокетов. Веб-сокеты не могут быть инициализированы.');

//Эта функция выполняется немедленно с JQuery
+function ($) {
    "use strict";

    /**
     * Данные запроса переодим в объект
     * @param queryString
     * @param decode
     * @returns {{}}
     */
    function queryStringToObject(queryString, decode) {
        var query = queryString.split('&'),
            obj = {};

        for (var i = 0, l = query.length; i < l; i++) {
            var keyVal = query[i].split('=');
            obj[keyVal[0]] = decode ? decodeURIComponent(keyVal[1]) : keyVal[1];
        }

        return obj;
    }

    /**
     * Получаем данные в теге '/plugins/alekseypavlov/chat/assets/javascript/websocket.js?'
     * @returns {string}
     */
    function getQueryString() {
        var scriptTags = document.getElementsByTagName('script');
        return scriptTags[scriptTags.length - 1].src.split('?')[1];
    }

    /**
     * Если пришло сообщение с сервера
     * @param message
     */
    function onMessage(message) {
        var event = JSON.parse(message.data);

        if (!event.name) {
            throw new Error('Неправильное имя события.');
        }

        var attrName = 'websocket-on' + event.name,
            selector = '[data-' + attrName + ']';

        //Инициируем событие что пришел запрос с сервера
        $(document).trigger(jQuery.Event('websocket' + ':' + event.name, {payload: event.payload}));

        $(selector).each(function () {
            eval('(function(event) {' + $(this).data(attrName) + '}.call(this, event))');
        });
    }

    function websocketSend() {
        var $el   = $(this),
            $form = $el.closest('form'),
            data  = queryStringToObject($form.serialize()),
            eventName = $el.data(TRIGGER_ATTR);

        var event = {
            name: eventName,
            payload: data
        };

        websocket.send(JSON.stringify(event));
    }

    $.fn.websocketSend = websocketSend;

    $('.chat-popup form').on('submit', '[data-websocket-event]', function (event) {
        $(this).websocketSend();
        event.preventDefault();
    });

    /**
     * Инициализация веб-сокетов
     */
        //Свойства веб-сокетов
    var properties = queryStringToObject(getQueryString(), true),
        websocket = null;
    websocket = new WebSocket(properties.uri);
    websocket.onmessage = onMessage;

}(jQuery);