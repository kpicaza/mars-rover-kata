<?php

declare(strict_types=1);

namespace Kpicaza\MarsRover;

final class Navigation
{

    public function __construct(
        private Position  $position,
        private Direction $direction
    ) {
    }

    public function navigate(string $operation, string $command): void
    {
        switch ($operation) {
            case 'move':
                $this->move($command);
                return;
            case 'rotate':
                $this->rotate($command);
                return;
        }
    }

    public function position(): Position
    {
        return $this->position;
    }

    public function direction(): Direction
    {
        return $this->direction;
    }

    private function move(string $command): void
    {
        switch ($command) {
            case 'forward':
                $this->moveForward();
                break;
            case 'backward':
                $this->moveBackward();
                break;
        }
    }

    private function rotate(string $command): void
    {
        switch ($command) {
            case 'left':
                $this->direction = $this->direction->rotateToLeft();
                return;
            case 'right':
                $this->direction = $this->direction->rotateToRight();
                return;
        }
    }

    private function moveForward(): void
    {
        switch ($this->direction->direction) {
            case 'N':
                $this->position = $this->position->addXAxis();
                break;
            case 'W':
                $this->position = $this->position->addYAxis();
                break;
            case 'S':
                $this->position = $this->position->subXAxis();
                break;
            case 'E':
                $this->position = $this->position->subYAxis();
                break;
        }
    }

    private function moveBackward(): void
    {
        switch ($this->direction->direction) {
            case 'N':
                $this->position = $this->position->subXAxis();
                break;
            case 'W':
                $this->position = $this->position->subYAxis();
                break;
            case 'S':
                $this->position = $this->position->addXAxis();
                break;
            case 'E':
                $this->position = $this->position->addYAxis();
                break;
        }
    }
}
    