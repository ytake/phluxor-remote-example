<?php

declare(strict_types=1);

namespace PhluxorExample\Message;

readonly class ClassFinished
{
    public function __construct(
        public string $subject
    ) {
    }
}
