<?php

declare(strict_types=1);

namespace PhluxorExample\Message;

final readonly class LocalHello
{
    public function __construct(
        public string $name
    ) {
    }

    public function __toString(): string
    {
        return 'LocalHello(' . $this->name . ')';
    }
}
