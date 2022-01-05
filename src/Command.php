<?php

declare(strict_types=1);

namespace Kpicaza\MarsRover;

final class Command
{
    public function __construct(
        public readonly string $operation,
        public readonly string $command,
    ) {
    }
}
    