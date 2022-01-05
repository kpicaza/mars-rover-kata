<?php

declare(strict_types=1);

namespace Test\Kpicaza\MarsRover;

use Kpicaza\MarsRover\Direction;
use Kpicaza\MarsRover\Navigation;
use Kpicaza\MarsRover\Position;
use PHPUnit\Framework\TestCase;

final class NavigationTest extends TestCase
{
    private const X_POSITION = 0;
    private const Y_POSITION = 0;
    private const NORTH = 'N';

    public function testItHasStartingPointAndFacingDirection(): void
    {
        $navigation = new Navigation(
            new Position(self::X_POSITION,  self::Y_POSITION),
            new Direction(self::NORTH),
        );

        $this->assertInstanceOf(Navigation::class, $navigation);
    }
}
    