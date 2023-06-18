<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace Hyperf\Octopus\MsgQueue\Amqp;

use Hyperf\Amqp\Builder\QueueBuilder;
use Hyperf\Amqp\Message\ConsumerMessage;
use Hyperf\Amqp\Result;
use Hyperf\Codec\Json;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Octopus\Event\Event;
use Hyperf\Octopus\Event\EventReceived;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\EventDispatcher\EventDispatcherInterface;
use Throwable;

class EventConsumer extends ConsumerMessage
{
    public function consumeMessage($data, AMQPMessage $message): string
    {
        try {
            $event = Event::jsonDeSerialize($data);

            $this->container->get(EventDispatcherInterface::class)->dispatch(new EventReceived($event));
        } catch (Throwable $exception) {
            if ($logger = $this->container?->get(StdoutLoggerInterface::class)) {
                $logger->error(Json::encode([
                    'event' => $event ?? null,
                    'exception' => (string) $exception,
                ]));
            }
        }

        return Result::ACK;
    }

    public function getQueueBuilder(): QueueBuilder
    {
        return parent::getQueueBuilder()->setAutoDelete(true);
    }
}
