<?php
require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Message\AMQPMessage;

class Message
{
    private $_value;
    private $_channel;
    private $_queue;

    public function __construct($value, $queue)
    {
        $this->setQueue($queue);
        $this->setValue($value);
    }

    public function run()
    {
        $channel = $this->getChannel();

        $channel->queue_declare($this->getQueue(), false, false, false, false);
        $msg = new AMQPMessage($this->getValue());

        $channel->basic_publish($msg, '', $this->getQueue());
        echo " [x] Sent ".$this->getValue()."\n";
        
        $this->getChannel()->close();
    }

    /**
     * Get the value of _value
     */ 
    public function getValue()
    {
        return $this->_value;
    }

    /**
     * Set the value of _value
     *
     * @return  self
     */ 
    public function setValue($value)
    {
        $this->_value = $value;

        return $this;
    }

    /**
     * Get the value of _channel
     */ 
    public function getChannel()
    {
        return $this->_channel;
    }

    /**
     * Set the value of _channel
     *
     * @return  self
     */ 
    public function setChannel($channel)
    {
        $this->_channel = $channel;

        return $this;
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