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
namespace App\Listener;

use Hyperf\Event\Annotation\Listener;
use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Octopus\Client\WebSocketClient;
use Hyperf\Octopus\Event\EventReceived;
use Hyperf\Octopus\Node;
use Psr\Container\ContainerInterface;

#[Listener]
class EventReceivedListener implements ListenerInterface
{
    public function __construct(protected ContainerInterface $container)
    {
    }

    public function listen(): array
    {
        return [EventReceived::class];
    }

    /**
     * @param EventReceived $event
     */
    public function process(object $event): void
    {
        $event = $event->event;
        if ($this->container->get(Node::class)->isEqual($event->getNodeId())) {
            $this->container->get(WebSocketClient::class)->handle($event);
        }
    }
}
