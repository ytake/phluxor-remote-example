<?php

declare(strict_types=1);

namespace PhluxorExample\Message;

readonly class StartsClass
{
    public function __construct(
        public string $subject
    ) {
    }
}
