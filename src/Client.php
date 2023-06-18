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
namespace Hyperf\Octopus;

use Hyperf\Amqp\Producer;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Octopus\Event\EventInterface;
use Hyperf\Octopus\Exception\InvalidArgumentException;
use Hyperf\Octopus\MsgQueue\Amqp\EventProducer;
use Psr\Container\ContainerInterface;

class Client
{
    protected Node $node;

    public function __construct(protected ContainerInterface $container)
    {
        $this->node = $this->container->get(Node::class);
    }

    public function push(EventInterface $event): bool
    {
        if ($event->getNodeId() === $this->node->getId()) {
            return $this->handle($event);
        }

        $config = $this->container->get(ConfigInterface::class)->get('octopus.mq');
        $driver = $config['driver'];
        switch ($driver) {
            case 'amqp':
                return $this->container->get(Producer::class)->produce(new EventProducer($event));
            default:
                throw new InvalidArgumentException(sprintf('The driver %s is invalid', $driver));
        }
    }

    /**
     * You can extend this class and rewrite this method.
     */
    public function handle(EventInterface $event): bool
    {
        return true;
    }
}
