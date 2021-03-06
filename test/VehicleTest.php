<?php

declare(strict_types=1);

namespace Test\Kpicaza\MarsRover;

use Generator;
use Kpicaza\MarsRover\Command;
use Kpicaza\MarsRover\Direction;
use Kpicaza\MarsRover\Exception\ObstacleDetected;
use Kpicaza\MarsRover\Navigator;
use Kpicaza\MarsRover\ObstacleInPosition;
use Kpicaza\MarsRover\Position;
use Kpicaza\MarsRover\Vehicle;
use PHPUnit\Framework\TestCase;

final class VehicleTest extends TestCase
{
    public function testReceivedACharacterArrayOfCommands(): void
    {
        $obstacleInPosition = $this->createMock(ObstacleInPosition::class);
        $commands = [
            new Command('move', 'forward'),
            new Command('rotate', 'left'),
            new Command('move', 'forward'),
            new Command('move', 'forward'),
        ];
        $vehicle = new Vehicle(new Position(0, 0), new Direction('N'), new Navigator($obstacleInPosition));
        $vehicle->run($commands);

        $this->assertSame(1, $vehicle->position()->x);
        $this->assertSame(2, $vehicle->position()->y);
        $this->assertSame('W', $vehicle->direction()->direction);
    }

    public function testExecuteCommandsUntilMeetAnObstacle(): void
    {
        $this->expectException(ObstacleDetected::class);
        $this->expectExceptionMessage('Obstacle detected at: [x: 1, y: 2]');
        $obstacleInPosition = $this->createMock(ObstacleInPosition::class);
        $obstacleInPosition->expects($this->exactly(3))
            ->method('isSatisfiedBy')
            ->willReturnOnConsecutiveCalls(false, false, true);
        $commands = [
            Command::fromSingleLetterCommand('F'),
            Command::fromSingleLetterCommand('L'),
            Command::fromSingleLetterCommand('F'),
            Command::fromSingleLetterCommand('F'),
        ];
        $vehicle = new Vehicle(new Position(0, 0), new Direction('N'), new Navigator($obstacleInPosition));
        $vehicle->run($commands);

        $this->assertSame(1, $vehicle->position()->x);
        $this->assertSame(1, $vehicle->position()->y);
        $this->assertSame('W', $vehicle->direction()->direction);
    }

    /** @dataProvider getMoveForwardData */
    public function testMoveVehicleForward(
        Position $position,
        Direction $direction,
        Position $expectedPosition,
        Direction $expectedDirection
    ): void {
        $obstacleInPosition = $this->createMock(ObstacleInPosition::class);
        $command = new Command('move', 'forward');
        $vehicle = new Vehicle($position, $direction, new Navigator($obstacleInPosition));
        $vehicle->run([
            $command
        ]);
        $vehicle->popEvents();

        $this->assertSame($expectedPosition->y, $vehicle->position()->y);
        $this->assertSame($expectedPosition->x, $vehicle->position()->x);
        $this->assertSame($expectedDirection->direction, $vehicle->direction()->direction);
    }

    /** @dataProvider getMoveBackwardData */
    public function testMoveVehicleBackward(
        Position $position,
        Direction $direction,
        Position $expectedPosition,
        Direction $expectedDirection
    ): void {
        $obstacleInPosition = $this->createMock(ObstacleInPosition::class);
        $command = new Command('move', 'backward');
        $vehicle = new Vehicle($position, $direction, new Navigator($obstacleInPosition));
        $vehicle->run([
            $command
        ]);
        $vehicle->popEvents();

        $this->assertSame($expectedPosition->y, $vehicle->position()->y);
        $this->assertSame($expectedPosition->x, $vehicle->position()->x);
        $this->assertSame($expectedDirection->direction, $vehicle->direction()->direction);
    }

    /** @dataProvider getRotateToLeftData */
    public function testRotateVehicleToLeft(
        Position $position,
        Direction $direction,
        Position $expectedPosition,
        Direction $expectedDirection
    ): void {
        $obstacleInPosition = $this->createMock(ObstacleInPosition::class);
        $command = new Command('rotate', 'left');
        $vehicle = new Vehicle($position, $direction, new Navigator($obstacleInPosition));
        $vehicle->run([
            $command
        ]);
        $vehicle->popEvents();

        $this->assertSame($expectedPosition->y, $vehicle->position()->y);
        $this->assertSame($expectedPosition->x, $vehicle->position()->x);
        $this->assertSame($expectedDirection->direction, $vehicle->direction()->direction);
    }

    /** @dataProvider getRotateToRightData */
    public function testRotateVehicleToRight(
        Position $position,
        Direction $direction,
        Position $expectedPosition,
        Direction $expectedDirection
    ): void {
        $obstacleInPosition = $this->createMock(ObstacleInPosition::class);
        $command = new Command('rotate', 'right');
        $vehicle = new Vehicle($position, $direction, new Navigator($obstacleInPosition));
        $vehicle->run([
            $command
        ]);
        $vehicle->popEvents();

        $this->assertSame($expectedPosition->y, $vehicle->position()->y);
        $this->assertSame($expectedPosition->x, $vehicle->position()->x);
        $this->assertSame($expectedDirection->direction, $vehicle->direction()->direction);
    }

    public function getMoveForwardData(): Generator
    {
        yield 'Move from the North' => [
            new Position(0, 0),
            new Direction('N'),
            new Position(1, 0),
            new Direction('N'),
        ];

        yield 'Move from the North to planet limit' => [
            new Position(4, 0),
            new Direction('N'),
            new Position(0, 0),
            new Direction('N'),
        ];

        yield 'Move from the West' => [
            new Position(0, 0),
            new Direction('W'),
            new Position(0, 1),
            new Direction('W'),
        ];

        yield 'Move from the West to planet limit' => [
            new Position(0, 4),
            new Direction('W'),
            new Position(0, 0),
            new Direction('W'),
        ];

        yield 'Move from the South' => [
            new Position(0, 0),
            new Direction('S'),
            new Position(4, 0),
            new Direction('S'),
        ];

        yield 'Move from the East' => [
            new Position(0, 0),
            new Direction('E'),
            new Position(0, 4),
            new Direction('E'),
        ];
    }

    public function getMoveBackwardData(): Generator
    {
        yield 'Move from the North' => [
            new Position(0, 0),
            new Direction('N'),
            new Position(4, 0),
            new Direction('N'),
        ];

        yield 'Move from the West' => [
            new Position(0, 0),
            new Direction('W'),
            new Position(0, 4),
            new Direction('W'),
        ];

        yield 'Move from the South' => [
            new Position(0, 0),
            new Direction('S'),
            new Position(1, 0),
            new Direction('S'),
        ];

        yield 'Move from the East' => [
            new Position(0, 0),
            new Direction('E'),
            new Position(0, 1),
            new Direction('E'),
        ];
    }

    public function getRotateToLeftData(): Generator
    {
        yield 'Rotate from the North' => [
            new Position(0, 0),
            new Direction('N'),
            new Position(0, 0),
            new Direction('W'),
        ];

        yield 'Rotate from the West' => [
            new Position(0, 0),
            new Direction('W'),
            new Position(0, 0),
            new Direction('S'),
        ];

        yield 'Rotate from the South' => [
            new Position(0, 0),
            new Direction('S'),
            new Position(0, 0),
            new Direction('E'),
        ];

        yield 'Rotate from the East' => [
            new Position(0, 0),
            new Direction('E'),
            new Position(0, 0),
            new Direction('N'),
        ];
    }

    public function getRotateToRightData(): Generator
    {
        yield 'Rotate from the North' => [
            new Position(0, 0),
            new Direction('N'),
            new Position(0, 0),
            new Direction('E'),
        ];

        yield 'Rotate from the West' => [
            new Position(0, 0),
            new Direction('W'),
            new Position(0, 0),
            new Direction('N'),
        ];

        yield 'Rotate from the South' => [
            new Position(0, 0),
            new Direction('S'),
            new Position(0, 0),
            new Direction('W'),
        ];

        yield 'Rotate from the East' => [
            new Position(0, 0),
            new Direction('E'),
            new Position(0, 0),
            new Direction('S'),
        ];
    }
}
    