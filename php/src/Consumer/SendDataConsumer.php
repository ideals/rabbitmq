<?php

namespace App\Consumer;


use Interop\Queue\Context;
use Interop\Queue\Message;
use Interop\Queue\Processor;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

class SendDataConsumer implements Processor, LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * @inheritDoc
     */
    public function process(Message $message, Context $context): object|string
    {
        $phone = $message->getBody();

        $this->logger->info('это наше сообщение: ' . $phone);

        return Processor::ACK;
    }
}
