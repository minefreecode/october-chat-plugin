if (window.jQuery === undefined)
    throw new Error('Библиотека JQuery не загружена. Веб-сокеты не могут быть инициализированы.');

if (window.WebSocket === undefined)
    throw new Error('Ваш праузер не поддерживает API вебсокетов. Веб-сокеты не могут быть инициализированы.');

//Эта функция выполняется немедленно с JQuery
+function ($) {
    //"use strict";

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

        let last_date = $('span.date:last').text().trim();

        let item = (last_date != event.payload.date ? '<span class="date">' + event.payload.created_at + '</span>' : '')
            +
            `<li class="user-message">
            <div class="user-info">
                <img src="/plugins/alekseypavlov/chat/assets/images/unnamed.png" alt="avatar"/>
                <div class="about">
                    <div class="name">` + event.payload.username + `, ` + event.payload.created_at + `</div>
                </div>
                <br/>
            </div>
            <div class="message-text">
                ` + event.payload.msg + `
            </div>
        </li>`;


        $('.chat-popup form ul').append(item);
    }

    /**
     * Отправка сообщений на сервер веб-сокетов
     */
    function websocketSend() {
        var $el = $(this),
            $form = $el.closest('form'),
            data = queryStringToObject($form.serialize()),
            eventName = $el.data('websocket-on');

        var event = {
            name: 'websocket-on-submit',
            payload: data
        };

        websocket.send(JSON.stringify(event));//Отправить сериализированный объект
        $form.find('textarea').val('');
    }

    //Привязываем функцию к JQuery-объектам
    $.fn.websocketSend = websocketSend;

    //Отправка сообщения с формы
    $('.chat-popup form').submit(function (event) {
        $(this).websocketSend();//Вызов функции отправки
        event.preventDefault();
    });

    /**
     * Инициализация веб-сокетов
     */
        //Свойства веб-сокетов
    var properties = queryStringToObject(getQueryString(), true),
        websocket = null;

    //Создаем клиентский сервер
    websocket = new WebSocket(properties.uri);
    websocket.onmessage = onMessage;

    websocket.onopen = function (msg) {
        console.log(msg);

        console.log('Connection successfully opened');
    };


    websocket.onclose = function (msg) {
        console.log(msg);
        console.log('Connection was closed.');
    }


    websocket.error = function (err) {
        console.log(err); // Write errors to console
    }

}(jQuery);
