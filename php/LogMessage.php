<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/Message/Abstract.php';
require_once __DIR__ . '/Message/Interface.php';

use PhpAmqpLib\Message\AMQPMessage;

/**
 * Classe de mensagem
 */
class LogMessage extends Message_Abstract
implements Message_Interface
{
    /**
     * Envia a mensagem
     */
    public function run() : void
    {
        $channel = $this->getChannel();
        $this->setQueue("logs");
        $this->setValue("Logs");

        $channel->exchange_declare($this->getQueue(), 'fanout', $this->getDurable(), false, false);
        $msg = new AMQPMessage($this->getValue());
        $channel->basic_publish($msg, $this->getQueue());

        echo " [x] Sent ".$this->getValue()."\n";
        
        $this->getChannel()->close();
    }

}