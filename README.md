Este repositório apresenta um exemplo de uso do serviço RabbitMQ utilizando a biblioteca de implementação de AMQP em PHP php-amqplib.
As classes aqui presentes foram baseadas nos 4 primeiros tutoriais do site do RabbitMQ: https://www.rabbitmq.com/tutorials/tutorial-one-php.html

## Requisitos
*   É necessário ter o PHP >=5.6.3, RabbitMQ e Composer instalados.

## Enviando e recebendo mensagens

- Faça um clone deste repositório;
- Entre no diretório php/ e digite o comando: ```composer i```;
- Realize o comando para checar o status do serviço do RabbitMQ: ```rabbitmqctl status```;
- Caso o RabbitMQ não esteja rodando, realize o comando para inicia-lo: ```service rabbitmq-server start```;

A declaração do exchange está configurada com o tipo "fanout" neste repositório, esse tipo de envio permite que as mensagens enviadas sejam entregues a todos os consumidores subscritos na fila em modo multicast.

- Para receber mensagens, abra um terminal no diretório php/ e execute: ```php Receive.php```

- Para enviar mensagens, abra outro terminal no diretório php/ e execute: ```php Send.php {$mensagem}```
    * Exemplo: ```php Send.php "enviando mensagem"```

Ao abrir mais de um terminal para receber mensagens é possível verificar que todos vão receber as mensagens enviadas para a fila que eles estão relacionados.

## RabbitMQ 
O RabbitMQ é um serviço de mensageria que utiliza protocolo AMQP, que permite o envio e recebimento de mensagens de forma assíncrona, ele foi escrito em Erlang, roda nos principais sistemas operacionais, é Open Source e pode ter suporte comercial.

### Mensagens
No RabbitMQ uma mensagem possui duas partes: uma é o payload, no qual o conteúdo da mensagem é armazenado e a outra é o label que indentifica quem deve recebe-la. 
Ao enviar a mensagem, o RabbitMQ entrega o payload para um dos consumidores que estão subscritos na fila.

### Conexão 
A conexão TCP é utilizada pelo RabbitMQ para o envio e recebimento de mensagens, após conectada e autenticada, é criado um canal AMQP, que é uma conexão virtual dentro na conexão real TCP. A criação de canais é ilimitada dentro de uma conexão TCP.

### Filas
Existem 3 componentes em um roteamento de uma mensagem AMQP:
* Exchanges: Onde as mensagens são publicadas;
* Queues: Onde as mensagens são armazenadas e recebidas pelos consumidores;
* Bindings: Modo de roteamento de uma exchange para uma queue.

#### Envio e recebimento de mensagens
Quando uma mensagem é enviada para uma fila, se existir algum consumidor subscrito nela, a mensagem é enviada diretamente a ele, caso contrário a mensagem fica na fila até que apareça algum subscritor.
Se existe mais de um subscritor na fila, as mensagens são enviadas por modo round-robin.
Uma fila pode ser ligada a uma exchange por uma routing key, isso não é obrigatório, mas permite que diversos casos diferentes de entrega de mensagens aconteçam. Para isso, existem 4 tipos diferentes de exchanges:
* Direct: Caso tenha sido configurada uma routing key, a mensagem será entregue para o consumidor que esteja subscrito na fila que possui a mesma routing key. Caso a roting key esteja em branco, as mensagens serão enviadas para os consumidores que estão subscritos na fila que possui a roting key em branco também;
* Fanout: Envia as mensagens em multicast para todos os consumidores que estejam subscritos na fila ligado a exchange;
* Topic: Permite que mensagens de diferentes fontes vá para a fila;
* Headers: Pode ser definida uma routing key no lugar da outra e tendo a mesma funcionalidade, a desvantagem é a perda considerável de desempenho.

### Virtual Hosts
Em cada servidor RabbitMQ é possível criar messages brokers virtuais que são virtual hosts (vhosts), evitando assim colisões de nomes de filas e exchanges.

## Referências

https://www.concrete.com.br/2012/01/26/rabbitmq-conceitos-basicos/

https://www.rabbitmq.com/

https://github.com/php-amqplib/php-amqplib

