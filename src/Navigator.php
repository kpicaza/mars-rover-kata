<?php

declare(strict_types=1);

namespace Kpicaza\MarsRover;

use Kpicaza\MarsRover\Exception\ObstacleDetected;

final class Navigator
{
    public function __construct(
        private ObstacleInPosition $obstacleInPosition
    ) {
    }

    public function move(
        Position $position,
        Direction $direction,
        string $command
    ): Position {
        switch ($command) {
            case 'forward':
                $position = $this->moveForward($position, $direction);
                break;
            case 'backward':
                $position = $this->moveBackward($position, $direction);
                break;
        }

        if ($this->obstacleInPosition->isSatisfiedBy($position)) {
            throw ObstacleDetected::at($position);
        }

        return $position;
    }

    public function rotate(Direction $direction, string $command): Direction
    {
        switch ($command) {
            case 'left':
                return $direction->rotateToLeft();
            case 'right':
                return $direction->rotateToRight();
        }
    }

    private function moveForward(Position $position, Direction $direction): Position
    {
        switch ($direction->direction) {
            case 'N':
                return $position->addXAxis();
            case 'W':
                return $position->addYAxis();
            case 'S':
                return $position->subXAxis();
            case 'E':
                return $position->subYAxis();
        }
    }

    private function moveBackward(Position $position, Direction $direction): Position
    {
        switch ($direction->direction) {
            case 'N':
                return $position->subXAxis();
            case 'W':
                return $position->subYAxis();
            case 'S':
                return $position->addXAxis();
            case 'E':
                return $position->addYAxis();
        }
    }
}
    