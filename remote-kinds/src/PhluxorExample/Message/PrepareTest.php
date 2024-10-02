<?php

declare(strict_types=1);

namespace PhluxorExample\Message;

readonly class PrepareTest
{
    public function __construct(
        public string $subject
    ) {
    }
}