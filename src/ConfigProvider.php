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

use Hyperf\Di\Definition\PriorityDefinition;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                Node::class => new PriorityDefinition(NodeFactory::class),
            ],
            'annotations' => [
                'scan' => [
                    'paths' => [
                        __DIR__,
                    ],
                ],
            ],
            'publish' => [
                [
                    'id' => 'config',
                    'description' => 'The config for octopus.',
                    'source' => __DIR__ . '/../publish/octopus.php',
                    'destination' => BASE_PATH . '/config/autoload/octopus.php',
                ],
            ],
        ];
    }
}
