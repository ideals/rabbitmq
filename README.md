## Symfony

Установка Symfony 6.0. Выбор версии обусловлен тем, что пакет php-amqplib/php-amqplib на момент установки
не поддерживал работу с PHP 8.1.

    symfony new stack --version="6.0.*"

Сайт доступен по адресу http://localhost/

## RabbitMQ

RabbitMQ доступен по адресу: http://localhost:8904/     
логин: bitrix    
пароль: bitrix

Продьюсер и консьюмер созданы и настроены в соответствии с инструкциями:
https://php-enqueue.github.io/bundle/message_producer/ и
https://php-enqueue.github.io/bundle/message_processor/

Очередь в RabbitMQ создаётся при запуске консьюмера:

    ./bin/console enqueue:consume --setup-broker -vvv

## Алгоритм отправки в очередь

1. В `services.yml` задаём класс-консьюмер очереди, и указываем, какую очередь и какой топик
он будет слушать. В этом примере консьюмер создаёт и слушает очередь `my.queue` и тему `my.topic`

```yaml
send_message_processor:
   class: App\Consumer\SendDataConsumer
   tags:
       - name: enqueue.processor
         topic: my.topic
         queue: my.queue
```

2. При отправке команды мы указываем тему `my-topic` 

```injectablephp
$this->producer->sendEvent('my.topic', new Message($message));
```
3. Бандл работы с очередями отправляет в сообщение в очередь `enqueue.app.default`, а оттуда, 
сообщение расходится в очереди, у которых указан соответствующий топик (как у сообщения). 
Поэтому если есть несколько очередей с одинаковыми топиками, то сообщение будет  в каждой из них.
