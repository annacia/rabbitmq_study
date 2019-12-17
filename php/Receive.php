<?php
require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

/**
 * Classe responsável pelo recebimento de mensagens
 */
class Receive
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

    /**
     * @var bool
     * 
     * Indica se a mensagem recebida é de log ou nao
     */
    private $_isLog = false;

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
    public function __construct($host, $port, $username, $password, $isLog = false)
    {
        $this->setIsLog($isLog);
        $this->_connection = new AMQPStreamConnection($host, $port, $username, $password); //abre a conexao
        
    }
    
    /**
     * Executa o recebimento de mensagens
     * 
     * @return void
     */
    public function run()
    {
        $channel = $this->_connection->channel();

        if ($this->getIsLog()) {
            $channel->exchange_declare('logs', 'fanout', false, false, false);
            list($queue_name, ,) = $channel->queue_declare("", false, false, true, false);
            $channel->queue_bind($queue_name, 'logs');
        } else {
            $channel->queue_declare($this->getQueue(), false, $this->getDurable(), false, false); //declara a fila de espera
            $channel->basic_qos(null, 1, null); //impede que mensagens sejam recebidas caso a anterior nao tenha sido processada 
        }
        
        echo " [*] Waiting for messages. To exit press CTRL+C\n";
        
        $callback = function ($msg) { //funcao que ira buscar mensagens recebidas
            echo ' [x] Received ', $msg->body, "\n";
            sleep(substr_count($msg->body, '.')); //simula um envio de dados grande
            echo " [x] Done\n";
            $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']); //retorna a mensagem
        };
        
        $channel->basic_consume($this->getQueue(), '', false, false, false, false, $callback); //busca novas mensagens
  
        //Enquanto o cana esta buscando novas mensagens, aguarda
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
     * Get the value of _isLog
     *
     * @return  bool
     */ 
    public function getIsLog()
    {
        return $this->_isLog;
    }

    /**
     * Set the value of _isLog
     *
     * @param  bool  $isLog
     *
     * @return  self
     */ 
    public function setIsLog(bool $isLog)
    {
        $this->_isLog = $isLog;

        return $this;
    }
}

//Mensagem comum
// $receive = new Receive('10.4.4.4', 5672, 'carol', '123456');
// $receive->setDurable(true);
// $receive->setQueue('hello');
// $receive->run();

//Mensagem log - neste caso 2 ou mais receivers podem receber as mesmas mensagens ao mesmo tempo
$receive = new Receive('10.4.4.4', 5672, 'carol', '123456');
$receive->setIsLog(true);
$receive->run();