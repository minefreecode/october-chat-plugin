<?php namespace Alekseypavlov\Chat\Components;

use Alekseypavlov\Chat\Models\Message;
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
        return [];
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
       $this->messages = Message::orderBy('id')->get();
       \Log::info($this->messages);
    }

}


