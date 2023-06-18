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

use Hyperf\Amqp\Message\ProducerMessage;
use Hyperf\Octopus\Event\EventInterface;

class EventProducer extends ProducerMessage
{
    public function __construct(EventInterface $event)
    {
        $this->payload = [
            'node_id' => $event->getNodeId(),
            'fds' => $event->getFds(),
            'payload' => $event->getPayload(),
        ];
    }
}
