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
namespace Hyperf\Octopus\Client;

use Hyperf\Codec\Json;
use Hyperf\Octopus\Client;
use Hyperf\Octopus\Event\EventInterface;
use Hyperf\WebSocketServer\Sender;
use Psr\Container\ContainerInterface;

class WebSocketClient extends Client
{
    protected Sender $sender;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->sender = $container->get(Sender::class);
    }

    public function handle(EventInterface $event): bool
    {
        foreach ($event->getFds() as $fd) {
            $this->sender->push($fd, Json::encode($event->getPayload()));
        }
        return true;
    }
}
