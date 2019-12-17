<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/Message/Abstract.php';
require_once __DIR__ . '/Message/Interface.php';

use PhpAmqpLib\Message\AMQPMessage;

/**
 * Classe de mensagem
 */
class Message extends Message_Abstract
implements Message_Interface
{
    /**
     * Constrói o objeto Message
     * 
     * @param string $value //conteudo da mensagem
     * @param string $queue //nome da fila
     * 
     * @return void
     */
    public function __construct($value, $queue)
    {
        $this->setQueue($queue);
        $this->setValue($value);
    }

    /**
     * Envia a mensagem
     */
    public function run() : void
    {
        $channel = $this->getChannel();

        $channel->queue_declare($this->getQueue(), false, $this->getDurable(), false, false);
        $msg = new AMQPMessage(
            $this->getValue(),
            array('delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT)
        );

        $channel->basic_publish($msg, '', $this->getQueue());
        echo " [x] Sent ".$this->getValue()."\n";
        
        $this->getChannel()->close();
    }

}