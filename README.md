Esse repositório apresenta um exemplo de uso do serviço RabbitMQ utilizando a biblioteca de implementação de AMPQ em PHP php-ampqlib.
As classes aqui presentes foram baseadas nos 4 primeiros tutoriais do site do RabbitMQ: https://www.rabbitmq.com/tutorials/tutorial-one-php.html

## RabbitMQ 
O RabbitMQ é um serviço de mensageria que utiliza protocolo AMQP, ele foi escrito em Erlang, roda nos principais sistemas operacionais, é Open Source e pode ter suporte comercial.

## AMQP
O AMQP é um protocolo que permite o envio e recebimento de mensagens de forma assíncrona.

## Requisitos
*   É necessário ter o PHP 7 instalado;
*   É necessário ter o RabbitMQ instalado;
*   É necessário ter o Composer instalado.

## Enviando e recebendo mensagens

A declaração do exchange está configurada com o tipo "fanout" neste repositório, esse tipo de envio permite que as mensagens enviadas sejam entregues a todos os receivers do mesmo canal.

- Para enviar mensagens, abra um terminal no diretório php/ e execute: php Send.php {$mensagem}
    * Exemplo: php Send.php "enviando mensagem"

- Para receber mensagens, abra um terminal no diretório php/ e execute: php Receive.php

Ao abrir mais de um terminal para receber mensagens é possível verificar que todos vão receber as mensagens enviadas para o canal que eles estão relacionados.

## Referências

https://www.concrete.com.br/2012/01/26/rabbitmq-conceitos-basicos/

https://www.rabbitmq.com/

https://github.com/php-amqplib/php-amqplib

