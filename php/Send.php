<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once 'Message.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

class Send
{
    private $_connection;
    private $_message;

    public function __construct($host, $port)
    {
        $this->_connection = new AMQPStreamConnection($host, $port, 'guest', 'guest');
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

$send = new Send('10.0.0.2', 80);
$message = new Message('ooi', 'hello');

$send->setMessage($message)->run();