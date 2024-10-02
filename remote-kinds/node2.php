<?php

declare(strict_types=1);

use Phluxor\ActorSystem;
use Phluxor\ActorSystem\Context\ContextInterface;
use Phluxor\ActorSystem\Message\ReceiveFunction;
use Phluxor\ActorSystem\Props;
use Phluxor\Remote\Config;
use Phluxor\Remote\Remote;
use PhluxorExample\ClassroomActor;
use PhluxorExample\Message\ClassFinished;
use PhluxorExample\Message\StartsClass;

use function Swoole\Coroutine\run;

require_once __DIR__ . '/vendor/autoload.php';

run(function () {
    \Swoole\Coroutine\go(function () {
        $subject = 'math';
        $system = ActorSystem::create();
        $remote = new Remote(
            $system,
            new Config(
                'node2',
                50053,
                Config::withUseWebSocket(true)
            )
        );
        $remote->start();
        $pipe = $system->root()->spawn(
            Props::fromFunction(
                new ReceiveFunction(
                    function (ContextInterface $context): void {
                        $msg = $context->message();
                        if ($msg instanceof ClassFinished) {
                            $context->logger()->info(
                                sprintf('The class has ended: %s', $msg->subject)
                            );
                        }
                    }
                )
            )
        );
        $stream = $system->root()->spawnNamed(
            Props::fromProducer(
                fn() => new ClassroomActor($pipe, $subject, range(1, 20), $remote)
            ),
            'math-classroom'
        );
        $system->root()->send($stream->getRef(), new StartsClass($subject));
    });
});
