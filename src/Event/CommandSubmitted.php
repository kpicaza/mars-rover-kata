<?php

declare(strict_types=1);

namespace Kpicaza\MarsRover\Event;

use DateTimeImmutable;
use Kpicaza\MarsRover\Direction;
use Kpicaza\MarsRover\Position;

final class CommandSubmitted
{
    private function __construct(
        public readonly array $payload,
        public readonly DateTimeImmutable $occurredOn
    ) {
    }

    public static function occur(
        array $payload
    ): self {
        return new self($payload, new DateTimeImmutable());
    }

    public function position(): Position
    {
        return new Position($this->payload['position_x'], $this->payload['position_y']);
    }

    public function direction(): Direction
    {
        return new Direction($this->payload['direction']);
    }

    public function operation(): string
    {
        return $this->payload['operation'];
    }

    public function command(): string
    {
        return $this->payload['command'];
    }
}
    