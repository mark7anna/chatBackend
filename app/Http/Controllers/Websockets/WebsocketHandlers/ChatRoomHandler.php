<?php

namespace App\Http\Controllers\Websockets\WebsocketHandlers;

use App\Http\Controllers\Controller;
use BeyondCode\LaravelWebSockets\Apps\App;
use BeyondCode\LaravelWebSockets\QueryParameters;
use BeyondCode\LaravelWebSockets\WebSockets\Exceptions\UnknownAppKey;
use Exception;
use Illuminate\Http\Request;
use Ratchet\ConnectionInterface;
use Ratchet\RFC6455\Messaging\MessageInterface;
use Ratchet\WebSocket\MessageComponentInterface;

class ChatRoomHandler extends Controller implements MessageComponentInterface
{

    protected function verifyAppKey(ConnectionInterface $connection)
    {
        $appKey = QueryParameters::create($connection->httpRequest)->get('appKey');

        if (! $app = App::findByKey($appKey)) {
            throw new UnknownAppKey($appKey);
        }

        $connection->app = $app;

        return $this;
    }
    protected function generateSocketId(ConnectionInterface $connection)
    {
        $socketId = sprintf('%d.%d', random_int(1, 1000000000), random_int(1, 1000000000));

        $connection->socketId = $socketId;

        return $this;
    }
    
    function onOpen(ConnectionInterface $conn)
    {
        $this -> verifyAppKey($conn)-> generateSocketId($conn);
        dump('on open!') ;
    }
    
    function onClose(ConnectionInterface $conn)
    {
        
    }
    function onError(ConnectionInterface $conn, Exception $e)
    {
        
    }
    function onMessage(ConnectionInterface $conn, MessageInterface $msg)
    {
        dump($msg -> getPayload());
    }

}
