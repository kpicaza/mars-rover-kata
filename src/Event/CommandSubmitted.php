<?php

declare(strict_types=1);

namespace Kpicaza\MarsRover\Event;

use DateTimeImmutable;

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

    public function position(): array
    {
        return $this->payload['position'];
    }

    public function direction(): string
    {
        return $this->payload['direction'];
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
    