<?php

declare(strict_types=1);

namespace PhluxorExample\Message;

readonly class Hello
{
    public function __construct(
        public string $name
    ) {
    }
}
