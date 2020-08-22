<?php namespace alekseypavlov\chat\Classes;

use alekseypavlov\Chat\Models\Message;
use Cms\Classes\ComponentBase;
use October\Rain\Argon\Argon;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;


/**
 * Основной компонент для работы с сообщениями веб-сокетов
 * Class MessageComponent
 * @package alekseypavlov\chat\Classes
 */
class WebsocketServerComponent implements MessageComponentInterface
{
    /**
     * Хранилище для уникальной идентификации объектов
     * @var \SplObjectStorage
     */
    protected $connections;

    public function __construct()
    {
        $this->connections = new \SplObjectStorage;
    }

    /**
     * Открыто соединение
     * @param ConnectionInterface $conn
     */
    public function onOpen(ConnectionInterface $conn)
    {
        /**
         * Добавляем новое соединение
         */
        $this->connections->attach($conn);
    }

    /** Когда на сервер пришло сообщение
     *
     * @param ConnectionInterface $from_connection
     * @param string $message
     */
    public function onMessage(ConnectionInterface $from_connection, $message)
    {
        $event = json_decode($message);

        //Добавляем сообщение в БД
        $event->payload->msg = urldecode($event->payload->msg);
        $created = Message::create(['user_id' => $event->payload->user_id, 'text' => $event->payload->msg]);
        $created->load(['user']);//Обновляем данные пользователя

        $event->payload->username = $created->user->username;
        $date = Argon::createFromFormat("Y-m-d H:i:s", $created->created_at);
        $event->payload->created_at = $date->format("H:i:s");
        $event->payload->date = $date->format("Y-m-d");

        foreach ($this->connections as $connection) {
            //Сообщение отправляем только туда куда еще не отправляли
            if ($connection == $from_connection) {
                continue;
            }

            $connection->send(json_encode($event));
        }
    }

    /**
     * Соединение закрыто
     * @param ConnectionInterface $conn
     */
    public function onClose(ConnectionInterface $conn)
    {
        //Отсоединяемся от SplObjectStorage
        $this->connections->detach($conn);
    }

    /**
     * Произошла ошибка
     * @param ConnectionInterface $conn
     * @param \Exception $e
     */
    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        //Закрываем соединение
        $conn->close();
    }
}
