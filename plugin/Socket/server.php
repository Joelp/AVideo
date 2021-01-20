<?php
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Socket\Message;

require_once dirname(__FILE__) . '/../../videos/configuration.php';
require_once $global['systemRootPath'] . 'plugin/Socket/Message.php';
require_once $global['systemRootPath'] . 'objects/autoload.php';

if(!isCommandLineInterface()){
    die("Command line only");
}

$obj = AVideoPlugin::getDataObject("Socket");
ob_end_flush();
_mysql_close();
session_write_close();

_error_log("Starting Socket server at port {$obj->port}");
$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Message()
        )
    ),
    $obj->port
);

$server->run();