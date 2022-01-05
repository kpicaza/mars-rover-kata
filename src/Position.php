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
        $newY = $this->y + 1;
        if (Planet::Y_LENGTH === $newY) {
            $newY = 0;
        }

        return new self($this->x, $newY);
    }

    public function subYAxis(): self
    {
        $newY = $this->y - 1;
        if (0 > $newY) {
            $newY = Planet::Y_LENGTH - 1;
        }

        return new self($this->x, $newY);
    }

    public function addXAxis(): self
    {
        $newX = $this->x + 1;
        if (Planet::X_LENGTH === $newX) {
            $newX = 0;
        }

        return new self($newX, $this->y);
    }

    public function subXAxis(): self
    {
        $newX = $this->x - 1;
        if (0 > $newX) {
            $newX = Planet::X_LENGTH - 1;
        }

        return new self($newX, $this->y);
    }
}
    