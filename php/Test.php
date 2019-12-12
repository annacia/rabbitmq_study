<?php
// require_once 'Send.php';
// require_once 'Message.php';

// $send = new Send('localhost', 5672);
// $message = new Message('ooi', 'hello');

// $send->setMessage($message)->run();
// require_once 'Receive.php';
// $receive = new Receive('localhost', 5672);
// $receive->run();

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
$connection = new AMQPStreamConnection('10.4.4.4', 5672, 'carol', '123456');
$channel = $connection->channel();
$channel->queue_declare('hello', false, false, false, false);
$msg = new AMQPMessage('Hello World!');
$channel->basic_publish($msg, '', 'hello');
echo " [x] Sent 'Hello World!'\n";
$channel->close();
$connection->close();
