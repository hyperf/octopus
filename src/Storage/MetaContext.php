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

use Hyperf\Support\Traits\StaticInstance;

class MetaContext
{
    use StaticInstance;

    protected Meta $meta;

    public function getMeta(): Meta
    {
        return $this->meta;
    }

    public function setMeta(Meta $meta): static
    {
        $this->meta = $meta;
        return $this;
    }
}
