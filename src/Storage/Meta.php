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
namespace Hyperf\Octopus\Storage;

use Hyperf\Contract\Arrayable;
use Hyperf\Contract\JsonDeSerializable;
use Hyperf\Octopus\Node;
use JsonSerializable;

use function Hyperf\Octopus\app;

class Meta implements Arrayable, JsonSerializable, JsonDeSerializable
{
    public function __construct(public int|string $uid, public string $nodeId, public int $fd)
    {
    }

    public function toArray(): array
    {
        return [
            'uid' => $this->uid,
            'node_id' => $this->nodeId,
            'fd' => $this->fd,
        ];
    }

    public static function jsonDeSerialize(mixed $data): static
    {
        return new static($data['uid'], $data['node_id'], $data['fd']);
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }

    public static function make(int|string $uid, int $fd)
    {
        return new static(
            $uid,
            app()->get(Node::class)->getId(),
            $fd
        );
    }
}
