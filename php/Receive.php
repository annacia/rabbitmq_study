<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/Receive/Abstract.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

/**
 * Classe responsável pelo recebimento de mensagens
 */
class Receive extends Receive_Abstract
{
    /**
     * Executa o recebimento de mensagens
     * 
     * @return void
     */
    public function run()
    {
        $channel = $this->getConnection()->channel();

        $channel->exchange_declare($this->getQueue(), $this->getType(), $this->getDurable(), false, false);
        //("nome da fila", "tipo de exchange", "duravel?", "", "")

        list($queue_name, ,) = $channel->queue_declare("", false, false, true, false);
        //("nome da fila", "", "duravel?", "", "")

        $channel->queue_bind($queue_name, $this->getQueue());
        //("string gerada pelo list", "nome da fila")        

        $this->setQueue(null);

        echo " [*] Waiting for messages. To exit press CTRL+C\n";
        
        $callback = function ($msg) { //funcao que ira buscar mensagens recebidas
            echo ' [x] Received ', $msg->body, "\n";
            sleep(substr_count($msg->body, '.')); //simula um envio de dados grande
            echo " [x] Done\n";
            $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']); //retorna a mensagem
        };
        
        $channel->basic_consume($this->getQueue(), '', false, false, false, false, $callback); //busca novas mensagens
        //("nome da lista", "", "", "", "", "", "funcao de callback")
        
        //Enquanto o canal esta buscando novas mensagens, aguarda
        while ($channel->is_consuming()) {
            $channel->wait();
        }
        
        $channel->close();
        $connection->close();
    }
}

//Execucao de recebimento de mensagem
//php Receive.php

$receive = new Receive('10.4.4.4', 5672, 'carol', '123456');
$receive->setDurable(true);
$receive->setType('fanout');
$receive->setQueue('exchange_message');
$receive->run();