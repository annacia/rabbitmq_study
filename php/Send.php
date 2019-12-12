<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once 'Message.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

class Send
{
    private $_connection;
    private $_message;

    public function __construct($host, $port, $username, $password)
    {
        $this->_connection = new AMQPStreamConnection($host, $port, $username, $password);
    }

    public function run()
    {
        $channel = $this->_connection->channel();
        $this->getMessage()->setChannel($channel);
        $this->getMessage()->run();
        $this->_connection->close();
    }

    /**
     * Get the value of _message
     */ 
    public function getMessage()
    {
        return $this->_message;
    }

    /**
     * Set the value of _message
     *
     * @return  self
     */ 
    public function setMessage($message)
    {
        $this->_message = $message;

        return $this;
    }
}

$data = implode(' ', array_slice($argv, 1));
if (empty($data)) {
    $data = "Hello World!";
}

$send = new Send('10.4.4.4', 5672, 'carol', '123456');
$message = new Message($data, 'hello');

$send->setMessage($message)->run();