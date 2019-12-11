<?php
require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;


class Receive
{
    private $_connection;
    private $_queue;

    public function __construct($host, $port)
    {
        $this->_connection = new AMQPStreamConnection($host, $port, 'guest', 'guest');
        
    }
    
    public function run()
    {
        $channel = $this->_connection->channel();
        $channel->queue_declare($this->getQueue(), false, false, false, false);
        
        echo " [*] Waiting for messages. To exit press CTRL+C\n";
        
        $callback = function ($msg) {
            echo ' [x] Received ', $msg->body, "\n";
        };
        
        $channel->basic_consume($this->getQueue(), '', false, true, false, false, $callback);
        
        while ($channel->is_consuming()) {
            $channel->wait();
        }
        
        $channel->close();
        $connection->close();
    }


    /**
     * Get the value of _queue
     */ 
    public function geQueue()
    {
        return $this->_queue;
    }

    /**
     * Set the value of _queue
     *
     * @return  self
     */ 
    public function seQueue($queue)
    {
        $this->_queue = $queue;

        return $this;
    }
}

$receive = new Receive('localhost', 80);
$receive->run();