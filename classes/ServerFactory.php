<?php namespace alekseypavlov\chat\Classes;

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

class ServerFactory
{
    /** Создать сервер веб-сокетов
     * @param $port
     * @return IoServer
     */
    public static function create($port)
    {
        return IoServer::factory(new HttpServer(new WsServer(new WebsocketServerComponent())), $port);
    }
}
