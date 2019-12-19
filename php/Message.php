<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/Message/Abstract.php';

use PhpAmqpLib\Message\AMQPMessage;

/**
 * Classe de mensagem
 */
class Message extends Message_Abstract
{
    /**
     * Envia a mensagem
     * 
     * @return void
     */
    public function run()
    {
        $channel = $this->getChannel();

        $channel->exchange_declare($this->getQueue(), $this->getType(), $this->getDurable(), false, false);
        //("nome da fila", "tipo de exchange", "duravel?", "", "")

        $msg = new AMQPMessage($this->getValue()); //conteudo da mensagem
        
        $channel->basic_publish($msg, $this->getQueue());
        //("objeto da classe AMQPMessage", "nome da fila")

        echo " [x] Sent ".$this->getValue()."\n";
        
        $this->getChannel()->close();
    }
}