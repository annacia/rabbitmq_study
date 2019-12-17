<?php
require_once __DIR__ . '/../vendor/autoload.php';

use PhpAmqpLib\Message\AMQPMessage;

/**
 * Classe abstrata de mensagem
 */
class Message_Abstract
{
    /**
     * @var string
     * 
     * conteudo da mensagem
     */
    private $_value;

    /**
     * @var AMQPChannel
     * 
     * canal de mensagem
     */
    private $_channel;

    /**
     * @var string
     * 
     * nome da fila
     */
    private $_queue;

    /**
     * @var bool
     * 
     * indica se a mensagem sera guardada ou nao
     */
    private $_durable = false;

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

    /**
     * Get the value of _durable
     */ 
    public function getDurable()
    {
        return $this->_durable;
    }

    /**
     * Set the value of _durable
     *
     * @return  self
     */ 
    public function setDurable($durable)
    {
        $this->_durable = $durable;

        return $this;
    }
}