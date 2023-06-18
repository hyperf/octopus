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
namespace App\Middleware;

use Hyperf\Context\Context;
use Hyperf\Octopus\Storage\Meta;
use Hyperf\Octopus\Storage\MetaContext;
use Hyperf\Octopus\Storage\Storage;
use Hyperf\WebSocketServer\Context as WsContext;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class UserAuthMiddleware implements MiddlewareInterface
{
    public function __construct(protected ContainerInterface $container)
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $id = (int) ($request->getQueryParams()['id'] ?? 0);
        if ($id > 0) {
            $meta = Meta::make($id, Context::get(WsContext::FD));
            $this->container->get(Storage::class)->save($meta);
            MetaContext::instance()->setMeta($meta);
        }

        return $handler->handle($request);
    }
}
