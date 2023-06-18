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
namespace App\Controller;

use Hyperf\Contract\OnCloseInterface;
use Hyperf\Contract\OnMessageInterface;
use Hyperf\Contract\OnOpenInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Engine\WebSocket\Frame;
use Hyperf\Engine\WebSocket\Response;
use Hyperf\Octopus\Client\WebSocketClient;
use Hyperf\Octopus\Event\Event;
use Hyperf\Octopus\Node;
use Hyperf\Octopus\Storage\MetaContext;

class WebSocketController implements OnOpenInterface, OnMessageInterface, OnCloseInterface
{
    #[Inject]
    protected WebSocketClient $client;

    public function onClose($server, int $fd, int $reactorId): void
    {
    }

    public function onMessage($server, $frame): void
    {
        $response = (new Response($server))->init($frame);

        $meta = MetaContext::instance()->getMeta();

        $response->push(new Frame(payloadData: 'I am ' . $meta->uid));

        $frame = Frame::from($frame);

        $event = Event::makeByUid((string) $frame->getPayloadData(), ['message' => 'I am ' . $meta->uid]);

        $this->client->push($event);
    }

    public function onOpen($server, $request): void
    {
        $response = (new Response($server))->init($request);

        $response->push(new Frame(payloadData: 'Connected to ' . di()->get(Node::class)->getId()));
    }
}
