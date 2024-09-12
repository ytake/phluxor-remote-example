<?php

declare(strict_types=1);

namespace PhluxorExample\Message;

final readonly class LocalHelloReply
{
    public function __construct(
        public string $name
    ) {
    }

    public function __toString(): string
    {
        return 'LocalHelloReply(' . $this->name . ')';
    }
}
