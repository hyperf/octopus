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
namespace Hyperf\Octopus\Listener;

use Hyperf\Amqp\Annotation\Consumer as AmqpConsumer;
use Hyperf\Amqp\Annotation\Producer as AmqpProducer;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Di\Annotation\AnnotationCollector;
use Hyperf\Event\Annotation\Listener;
use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Framework\Event\BootApplication;
use Hyperf\Octopus\MsgQueue\Amqp\EventConsumer;
use Hyperf\Octopus\MsgQueue\Amqp\EventProducer;
use Hyperf\Octopus\Node;
use Psr\Container\ContainerInterface;

#[Listener]
class BootMsgQueueProducerListener implements ListenerInterface
{
    public function __construct(protected ContainerInterface $container)
    {
    }

    public function listen(): array
    {
        return [BootApplication::class];
    }

    public function process(object $event): void
    {
        $config = $this->container->get(ConfigInterface::class)->get('octopus.mq');
        $driver = $config['driver'];
        switch ($driver) {
            case 'amqp':
                $options = array_merge(
                    [
                        'exchange' => 'octopus',
                        'routing_key' => 'octopus.event',
                        'queue_prefix' => 'octopus.event.queue.',
                    ],
                    $config['drivers']['amqp'] ?? []
                );

                AnnotationCollector::collectClass(EventProducer::class, AmqpProducer::class, new AmqpProducer($options['exchange'], $options['routing_key']));
                AnnotationCollector::collectClass(EventConsumer::class, AmqpConsumer::class, new AmqpConsumer(
                    $options['exchange'],
                    $options['routing_key'],
                    $options['queue_prefix'] . $this->container->get(Node::class),
                ));
                break;
        }
    }
}
