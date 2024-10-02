<?php

declare(strict_types=1);

use Phluxor\ActorSystem;
use Phluxor\Remote\Config;
use Phluxor\Remote\Remote;
use PhluxorExample\HelloResponseActor;

use function Swoole\Coroutine\run;

require_once __DIR__ . '/vendor/autoload.php';

run(function () {
    \Swoole\Coroutine\go(function () {
        $system = ActorSystem::create();
        $remote = new Remote(
            $system,
            new Config(
                'node1',
                50052,
                Config::withUseWebSocket(true)
            )
        );
        $remote->start();
        $props = ActorSystem\Props::fromProducer(
            fn() => new HelloResponseActor()
        );
        $system->root()->spawnNamed($props, 'hello');
        $ref = $system->root()->spawn(
            ActorSystem\Props::fromProducer(fn() => new \PhluxorExample\LocalActor())
        );
        $future = $system->root()->requestFuture(
            $ref,
            new \PhluxorExample\Message\LocalHello('node1 world'),
            1
        );
        var_dump((string) $future->result()->value()); // local hello
    });
});
