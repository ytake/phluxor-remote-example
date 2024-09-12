<?php

require_once __DIR__ . '/vendor/autoload.php';

use Phluxor\ActorSystem;
use Phluxor\Remote\Config;
use Phluxor\Remote\Remote;
use PhluxorExample\ProtoBuf\HelloRequest;

use function Swoole\Coroutine\run;

run(function () {
    \Swoole\Coroutine\go(function () {
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
        $future = $system->root()->requestFuture(
            new ActorSystem\Ref(new ActorSystem\ProtoBuf\Pid([
                'address' => 'node1:50052',
                'id' => 'hello',
            ])),
            new HelloRequest(['name' => 'world']),
            1
        );
        $r = $future->result();
        var_dump($r->value()->getMessage()); // Hello from remote node!
        \Swoole\Coroutine::sleep(1);
        $future = $system->root()->requestFuture(
            new ActorSystem\Ref(new ActorSystem\ProtoBuf\Pid([
                'address' => 'node1:50052',
                'id' => 'hello',
            ])),
            new HelloRequest(['name' => 'Phluxor']),
            1
        );
        $r = $future->result();
        var_dump($r->value()->getMessage()); // Hello from remote node!
        $ref = $system->root()->spawn(
            ActorSystem\Props::fromProducer(fn() => new \PhluxorExample\LocalActor())
        );
        $future = $system->root()->requestFuture(
            $ref,
            new \PhluxorExample\Message\LocalHello('node2 world'),
            1
        );
        var_dump((string) $future->result()->value()); // local hello
        $remote->shutdown();
    });
});
