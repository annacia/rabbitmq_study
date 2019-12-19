<?php
require_once __DIR__ . '/../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

/**
 * Classe responsável pelo recebimento de mensagens
 */
class Receive_Abstract
{
    /**
     * @var object
     * 
     * conexao AMPQ
     */
    private $_connection;

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

    private $_type;

    /**
     * Constrói o objeto Receive
     * 
     * @param $host
     * @param $port
     * @param $username
     * @param $password
     * 
     * @return void
     */
    public function __construct($host, $port, $username, $password)
    {
        $this->_connection = new AMQPStreamConnection($host, $port, $username, $password); //abre a conexao
    }

    public function getConnection()
    {
        return $this->_connection;
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

    /**
     * Get the value of _type
     */ 
    public function getType()
    {
        return $this->_type;
    }

    /**
     * Set the value of _type
     *
     * @return  self
     */ 
    public function setType($type)
    {
        $this->_type = $type;

        return $this;
    }
}