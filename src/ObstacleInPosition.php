<?php

declare(strict_types=1);

namespace Kpicaza\MarsRover;

interface ObstacleInPosition
{
    public function isSatisfiedBy(Position $position): bool;
}
    