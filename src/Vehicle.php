<?php

declare(strict_types=1);

namespace Kpicaza\MarsRover;

use Kpicaza\MarsRover\Event\CommandSubmitted;

final class Vehicle
{
    public function __construct(
        private Position $position,
        private Direction $direction,
        private Navigator $navigator,
        private array $events = []
    ) {
    }

    /**
     * @param Command[] $commands
     */
    public function run(array $commands): void
    {
        foreach ($commands as $command) {
            $this->recordThat(CommandSubmitted::occur([
                'position' => $this->position(),
                'direction' => $this->direction(),
                'operation' => $command->operation,
                'command' => $command->command,
            ]));
        }
    }

    private function whenCommandSubmitted(CommandSubmitted $event): void
    {
        switch ($event->operation()) {
            case 'move':
                $this->position = $this->navigator->move($this->position, $this->direction, $event->command());
                break;
            case 'rotate':
                $this->direction = $this->navigator->rotate($this->direction, $event->command());
                break;
        }
    }

    public function popEvents(): array
    {
        $events = $this->events;
        foreach ($this->events as $event) {
            $this->apply($event);
        }

        return $events;
    }

    private function recordThat(CommandSubmitted $occur): void
    {
        $this->events[] = $occur;
    }

    private function apply(CommandSubmitted $event): void
    {
        $this->whenCommandSubmitted($event);
    }

    public function position(): Position
    {
        return $this->position;
    }

    public function direction(): Direction
    {
        return $this->direction;
    }
}
