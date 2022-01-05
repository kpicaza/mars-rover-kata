<?php

declare(strict_types=1);

namespace Kpicaza\MarsRover;

final class Direction
{
    private const POINTS = [
        'N',
        'E',
        'S',
        'W',
    ];

    public function __construct(
        public readonly string $direction
    ) {
    }

    public function rotateToLeft(): self
    {
        $index = array_search($this->direction, self::POINTS) - 1;
        if (0 > $index) {
            $index = array_key_last(self::POINTS);
        }

        return new self(self::POINTS[$index]);
    }

    public function rotateToRight(): self
    {
        $index = array_search($this->direction, self::POINTS) + 1;
        if ($index === count(self::POINTS)) {
            $index = array_key_first(self::POINTS);
        }

        return new self(self::POINTS[$index]);
    }
}
    