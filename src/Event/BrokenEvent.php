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
namespace Hyperf\Octopus\Event;

class BrokenEvent extends Event
{
    public function __construct(public mixed $raw)
    {
        parent::__construct('', []);
    }

    public function isSuccess(): bool
    {
        return false;
    }
}
