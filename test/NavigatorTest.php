<?php

declare(strict_types=1);

namespace Test\Kpicaza\MarsRover;

use Kpicaza\MarsRover\Direction;
use Kpicaza\MarsRover\Navigator;
use Kpicaza\MarsRover\Position;
use PHPUnit\Framework\TestCase;

final class NavigatorTest extends TestCase
{
    private const X_POSITION = 0;
    private const Y_POSITION = 0;
    private const NORTH = 'N';

    public function testItHasStartingPointAndFacingDirection(): void
    {
        $navigation = new Navigator();

        $this->assertInstanceOf(Navigator::class, $navigation);
    }

    public function testNavigatorMoveForward(): void
    {
        $navigation = new Navigator();
        $position = $navigation->move(
            new Position(self::X_POSITION,  self::Y_POSITION),
            new Direction(self::NORTH),
            'forward'
        );
        $this->assertSame(1, $position->x);
        $this->assertSame(0, $position->y);
    }

    public function testNavigatorMoveBackward(): void
    {
        $navigation = new Navigator();
        $position = $navigation->move(
            new Position(self::X_POSITION,  self::Y_POSITION),
            new Direction(self::NORTH),
            'backward'
        );
        $this->assertSame(4, $position->x);
        $this->assertSame(0, $position->y);
    }

    public function testNavigatorRotateLeft(): void
    {
        $navigation = new Navigator();
        $direction = $navigation->rotate(
            new Direction(self::NORTH),
            'left'
        );
        $this->assertSame('W', $direction->direction);
    }

    public function testNavigatorRotateRight(): void
    {
        $navigation = new Navigator();
        $direction = $navigation->rotate(
            new Direction(self::NORTH),
            'right'
        );
        $this->assertSame('E', $direction->direction);
    }
}
    