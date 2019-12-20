<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once 'Message.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

/**
 * Classe responsável pelo envio de mensagens
 */
class Send
{
    /**
     * @var object
     * 
     * conexao AMPQ
     */
    private $_connection;

    /**
     * @var object
     * 
     * objeto da classe Message
     */
    private $_message;

    /**
     * Constrói um objeto da classe Send
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
        $this->_connection = new AMQPStreamConnection($host, $port, $username, $password);
    }

    /**
     * Envia mensagem
     */
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

//Execucao de envio de mensagem
//php Send.php {$mensagem}

$send = new Send('10.4.4.4', 5672, 'carol', '123456');

$data = implode(' ', array_slice($argv, 1));

if (empty($data)) {
    $data = "Mensagem Vazia";
}

$message = new Message($data, 'exchange_message');
$message->setDurable(true);
$message->setType('fanout');

$send->setMessage($message)->run();