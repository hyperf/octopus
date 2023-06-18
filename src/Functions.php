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

use Hyperf\Context\ApplicationContext;

/**
 * Finds an entry of the container by its identifier and returns it.
 * @return mixed|\Psr\Container\ContainerInterface
 */
function app(?string $id = null)
{
    $container = ApplicationContext::getContainer();
    if ($id) {
        return $container->get($id);
    }

    return $container;
}
