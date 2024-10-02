<?php

declare(strict_types=1);

use Phluxor\ActorSystem;

use Phluxor\ActorSystem\Props;
use Phluxor\Remote\Config;
use Phluxor\Remote\Remote;
use PhluxorExample\StudentActor;

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
                Config::withUseWebSocket(true),
                Config::withKinds(
                    new \Phluxor\Remote\Kind(
                        kind: 'student',
                        props: Props::fromProducer(
                            fn() => new StudentActor()
                        )
                    )
                )
            )
        );
        $remote->start();
    });
});
