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
return [
    'mq' => [
        'driver' => 'amqp',
        'drivers' => [
            'amqp' => [
                'exchange' => 'octopus',
                'routing_key' => 'octopus.event',
                'queue_prefix' => 'octopus.event.queue.',
            ],
        ],
    ],
    'storage' => [
        'driver' => 'redis',
        'drivers' => [
            'redis' => [
                // from `config/autoload/redis.php`.
                'pool' => 'default',
                'key_prefix' => '{octopus}:',
                'ttl' => 864000,
            ],
        ],
    ],
];
