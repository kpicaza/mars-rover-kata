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
            $this->execute($command);

            $this->popEvents();
        }
    }

    private function execute(Command $command): void
    {
        $this->recordThat(CommandSubmitted::occur([
            'position_x' => $this->position->x,
            'position_y' => $this->position->y,
            'direction' => $this->direction->direction,
            'operation' => $command->operation,
            'command' => $command->command,
        ]));
    }

    private function whenCommandSubmitted(CommandSubmitted $event): void
    {
        switch ($event->operation()) {
            case 'move':
                $this->position = $this->navigator->move($event->position(), $event->direction(), $event->command());
                break;
            case 'rotate':
                $this->direction = $this->navigator->rotate($event->direction(), $event->command());
                break;
        }
    }

    public function popEvents(): array
    {
        foreach ($this->events as $event) {
            $this->apply($event);
        }
        $events = $this->events;
        $this->events = [];

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
