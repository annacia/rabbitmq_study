<?php
require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;


class Receive
{
    private $_connection;
    private $_queue;

    public function __construct($host, $port, $username, $password)
    {
        $this->_connection = new AMQPStreamConnection($host, $port, $username, $password);
        
    }
    
    public function run()
    {
        $channel = $this->_connection->channel();
        $channel->queue_declare($this->getQueue(), false, false, false, false);
        
        echo " [*] Waiting for messages. To exit press CTRL+C\n";
        
        $callback = function ($msg) {
            echo ' [x] Received ', $msg->body, "\n";
            sleep(substr_count($msg->body, '.'));
            echo " [x] Done\n";
            $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
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
    public function getQueue()
    {
        return $this->_queue;
    }

    /**
     * Set the value of _queue
     *
     * @return  self
     */ 
    public function setQueue($queue)
    {
        $this->_queue = $queue;

        return $this;
    }
}

$receive = new Receive('10.4.4.4', 5672, 'carol', '123456');
$receive->setQueue('hello');
$receive->run();