<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once 'Message.php';
require_once 'LogMessage.php';

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
        var_dump(get_class($channel));
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

//Mensagens comuns
// $data = implode(' ', array_slice($argv, 1)); //pega a mensagem que foi passada como parametro no shell
// if (empty($data)) {
//     $data = "Mensagem Vazia";
// }

// $send = new Send('10.4.4.4', 5672, 'carol', '123456');
// $message = new Message($data, 'hello');
// $message->setDurable(true);

// $send->setMessage($message)->run();

//Mensagens de log
$send = new Send('10.4.4.4', 5672, 'carol', '123456');
$message = new LogMessage();
$send->setMessage($message)->run();