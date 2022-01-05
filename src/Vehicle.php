<?php

declare(strict_types=1);

namespace Kpicaza\MarsRover;

use Kpicaza\MarsRover\Event\CommandSubmitted;

final class Vehicle
{
    private array $events;
    private Navigation $navigation;

    public function __construct(
        Position $position,
        Direction $direction,
        array $events = []
    ) {
        $this->navigation = new Navigation(
            $position,
            $direction
        );
        $this->events = $events;
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
        $this->navigation->navigate(
            $event->operation(),
            $event->command()
        );
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
        return $this->navigation->position();
    }

    public function direction(): Direction
    {
        return $this->navigation->direction();
    }
}
