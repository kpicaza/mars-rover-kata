<?php

declare(strict_types=1);

namespace Kpicaza\MarsRover;

final class Position
{
    public function __construct(
        public readonly int $x,
        public readonly int $y
    ) {
    }

    public function addYAxis(): self
    {
        return new self($this->x, $this->y + 1);
    }

    public function subYAxis(): self
    {
        return new self($this->x, $this->y - 1);
    }

    public function addXAxis(): self
    {
        return new self($this->x + 1, $this->y);
    }

    public function subXAxis(): self
    {
        return new self($this->x - 1, $this->y);
    }
}
    