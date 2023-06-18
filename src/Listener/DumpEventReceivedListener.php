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

use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Octopus\Event\EventReceived;

class DumpEventReceivedListener implements ListenerInterface
{
    public function __construct()
    {
    }

    public function listen(): array
    {
        return [EventReceived::class];
    }

    public function process(object $event): void
    {
        var_dump($event);
    }
}
