<?php

namespace App\Command;


use Enqueue\Client\Message;
use Enqueue\Client\ProducerInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SendDataCommand extends Command implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    private const ARGUMENT_MESSAGE = 'message';

    /**
     * @var ProducerInterface
     */
    private ProducerInterface $producer;

    public function __construct(ProducerInterface $producer)
    {
        $this->producer = $producer;

        parent::__construct();
    }

    public function configure(): void
    {
        $this->setName('send:message')
            ->setDescription('Отправка сообщения в очередь')
            ->addArgument(
                self::ARGUMENT_MESSAGE,
                InputArgument::REQUIRED,
                'Текст сообщения должен быть указан'
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $message = $input->getArgument(self::ARGUMENT_MESSAGE);

        $this->producer->sendEvent('my.topic', new Message($message));

        $output->writeln('Сообщение отправлено: ' . $message);

        return 0;
    }
}
