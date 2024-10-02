<?php

declare(strict_types=1);

namespace PhluxorExample;

use Phluxor\ActorSystem\Context\ContextInterface;
use Phluxor\ActorSystem\Message\ActorInterface;
use PhluxorExample\Message\LocalHello;
use PhluxorExample\Message\LocalHelloReply;

class LocalActor implements ActorInterface
{
    public function receive(ContextInterface $context): void
    {
        $message = $context->message();
        if ($message instanceof LocalHello) {
            $context->respond(new LocalHelloReply($message->name));
        }
    }
}
