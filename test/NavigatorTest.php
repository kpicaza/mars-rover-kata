<?php

declare(strict_types=1);

namespace Test\Kpicaza\MarsRover;

use Kpicaza\MarsRover\Direction;
use Kpicaza\MarsRover\Exception\ObstacleDetected;
use Kpicaza\MarsRover\Navigator;
use Kpicaza\MarsRover\ObstacleInPosition;
use Kpicaza\MarsRover\Position;
use PHPUnit\Framework\TestCase;

final class NavigatorTest extends TestCase
{
    private const X_POSITION = 0;
    private const Y_POSITION = 0;
    private const NORTH = 'N';

    public function testItHasStartingPointAndFacingDirection(): void
    {
        $obstacleInPosition = $this->createMock(ObstacleInPosition::class);
        $navigation = new Navigator($obstacleInPosition);

        $this->assertInstanceOf(Navigator::class, $navigation);
    }

    public function testNavigatorMoveForward(): void
    {
        $obstacleInPosition = $this->createMock(ObstacleInPosition::class);
        $navigation = new Navigator($obstacleInPosition);
        $position = $navigation->move(
            new Position(self::X_POSITION,  self::Y_POSITION),
            new Direction(self::NORTH),
            'forward'
        );
        $this->assertSame(1, $position->x);
        $this->assertSame(0, $position->y);
    }

    public function testNavigatorDetectObstacleMovingForward(): void
    {
        $this->expectException(ObstacleDetected::class);
        $obstacleInPosition = $this->createMock(ObstacleInPosition::class);
        $obstacleInPosition->expects($this->once())
            ->method('isSatisfiedBy')
            ->with(new Position(1,  self::Y_POSITION))
            ->willReturn(true);
        $navigation = new Navigator($obstacleInPosition);
        $navigation->move(
            new Position(self::X_POSITION,  self::Y_POSITION),
            new Direction(self::NORTH),
            'forward'
        );
    }

    public function testNavigatorMoveBackward(): void
    {
        $obstacleInPosition = $this->createMock(ObstacleInPosition::class);
        $navigation = new Navigator($obstacleInPosition);
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
        $obstacleInPosition = $this->createMock(ObstacleInPosition::class);
        $navigation = new Navigator($obstacleInPosition);
        $direction = $navigation->rotate(
            new Direction(self::NORTH),
            'left'
        );
        $this->assertSame('W', $direction->direction);
    }

    public function testNavigatorRotateRight(): void
    {
        $obstacleInPosition = $this->createMock(ObstacleInPosition::class);
        $navigation = new Navigator($obstacleInPosition);
        $direction = $navigation->rotate(
            new Direction(self::NORTH),
            'right'
        );
        $this->assertSame('E', $direction->direction);
    }
}
    