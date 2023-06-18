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

use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Event\Annotation\Listener;
use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Framework\Event\BootApplication;
use Hyperf\Octopus\Node;
use Psr\Container\ContainerInterface;

#[Listener(99)]
class BootNodeListener implements ListenerInterface
{
    public function __construct(private ContainerInterface $container)
    {
    }

    public function listen(): array
    {
        return [BootApplication::class];
    }

    public function process(object $event): void
    {
        $node = $this->container->get(Node::class);

        if ($this->container->has(StdoutLoggerInterface::class)) {
            $this->container->get(StdoutLoggerInterface::class)->info(sprintf('The current node id is %s', $node->getId()));
        }
    }
}
