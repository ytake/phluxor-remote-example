<?php

declare(strict_types=1);

namespace PhluxorExample;

use Phluxor\ActorSystem\Context\ContextInterface;
use Phluxor\ActorSystem\Message\ActorInterface;
use PhluxorExample\ProtoBuf\HelloRequest;
use PhluxorExample\ProtoBuf\HelloResponse;

class HelloResponseActor implements ActorInterface
{
    public function receive(ContextInterface $context): void
    {
        $message = $context->message();
        if ($message instanceof HelloRequest) {
            $context->respond(new HelloResponse([
                'message' => sprintf(
                    'Hello %s from remote node. this is %s, %d',
                    $message->getName(),
                    $context->self(),
                    time()
                ),
            ]));
        }
    }
}
