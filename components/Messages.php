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

    //Получаем объект сообщений
    public function getMessages()
    {
        return Message::with('user')->orderBy('id')->get();

    }

    /**
     * When running this component, load all items based on the selections.
     */
    public function onRun()
    {
       //Получаем объект сообщений
       $this->messages = $this->getMessages();

        //Добавляем js самих веб-сокетов
        $props = $this->getProperties();
        $this->addJs('/plugins/alekseypavlov/chat/assets/javascript/chat.js?'.http_build_query($props));
        $this->addCss('/plugins/alekseypavlov/chat/assets/css/chat.css');
    }

}


