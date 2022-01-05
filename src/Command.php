<?php

declare(strict_types=1);

namespace Kpicaza\MarsRover;

final class Command
{
    private const COMMANDS = [
        'F' => ['move', 'forward'],
        'B' => ['move', 'backward'],
        'L' => ['rotate', 'left'],
        'R' => ['rotate', 'right'],
    ];

    public function __construct(
        public readonly string $operation,
        public readonly string $command,
    ) {
    }

    public static function fromSingleLetterCommand(string $command): self
    {
        return new self(...self::COMMANDS[$command]);
    }
}
    