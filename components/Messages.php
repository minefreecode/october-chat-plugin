<?php namespace Alekseypavlov\Chat\Components;

use alekseypavlov\Chat\Models\Message;
use Cms\Classes\ComponentBase;

class Messages extends ComponentBase
{
    /**
     * Сообщения
     * @var
     */
    public $messages;

    public function componentDetails()
    {
        return [
            'name'        => 'Компонент сообщений',
            'description' => 'Компонент для написания сообщений'
        ];
    }

    public function defineProperties()
    {
        return [
            'uri' => [
                'title'             => 'URI',
                'description'       => 'URI сервера веб-сокета',
                'default'           => 'ws://localhost:8080/',
                'type'              => 'string',
                'validationPattern' => '^ws\:\/\/.*',
                'validationMessage' => 'Введите валидный URI веб-сокета(ws://localhost:8080/)'
            ]
        ];
    }

    public function getMessages()
    {
        return Message::orderBy('id')->get();
    }

    /**
     * When running this component, load all items based on the selections.
     */
    public function onRun()
    {
       //Получаем объект сообщений
       $this->messages = Message::orderBy('id')->get();
        //Добавляем js самих веб-сокетов
        $props = $this->getProperties();
        $this->addJs('/plugins/alekseypavlov/chat/assets/javascript/websocket.js?'.http_build_query($props));
    }

    /**
     * Executed when this component is rendered on a page or layout.
     */
    public function onRender()
    {
        //Добавляем js самих веб-сокетов
        $props = $this->getProperties();
        $this->addJs('/plugins/alekseypavlov/chat/assets/javascript/websocket.js?'.http_build_query($props));
    }



}


