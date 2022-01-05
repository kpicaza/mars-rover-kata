<?php

declare(strict_types=1);

namespace Kpicaza\MarsRover\Exception;

use Kpicaza\MarsRover\Position;
use RuntimeException;

final class ObstacleDetected extends RuntimeException
{
    public static function at(Position $position): self
    {
        return new self(sprintf('Obstacle detected at: [x: %s, y: %s]', $position->x, $position->y));
    }
}
    