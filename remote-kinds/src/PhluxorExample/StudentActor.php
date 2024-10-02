<?php

declare(strict_types=1);

namespace PhluxorExample;

use Phluxor\ActorSystem\Context\ContextInterface;
use Phluxor\ActorSystem\Message\ActorInterface;
use PhluxorExample\ProtoBuf\StartTest;
use PhluxorExample\ProtoBuf\SubmitTest;
use Random\RandomException;

class StudentActor implements ActorInterface
{
    /**
     * @throws RandomException
     */
    public function receive(ContextInterface $context): void
    {
        $msg = $context->message();
        if ($msg instanceof StartTest) {
            sleep(random_int(1, 9));
            $context->logger()->info(
                sprintf(
                    '%s is submitting the answer to the %s test',
                    $context->self(),
                    $msg->getSubject()
                )
            );
            $context->send(
                $context->sender(),
                new SubmitTest([
                    'subject' => $msg->getSubject(),
                    'name' => (string) $context->self(),
                ])
            );
            $context->poison($context->self());
        }
    }
}
