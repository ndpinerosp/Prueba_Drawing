<?php

namespace App\Tests\Strategy;

use App\Strategy\HorizontalStrategy;
use PHPUnit\Framework\TestCase;

class HorizontalStrategyTest extends TestCase
{
    public function testDraw()
    {
        $canvas = [
            [' ', ' ', ' ', ' '],
            [' ', ' ', ' ', ' '],
            [' ', ' ', ' ', ' '],
        ];
        $strategy = new HorizontalStrategy();
        $strategy->draw($canvas, 1, 1, 3, 1);

        $expectedCanvas = [
            [' ', ' ', ' ', ' '],
            [' ', 'x', 'x', 'x'],
            [' ', ' ', ' ', ' '],
        ];

        $this->assertSame($expectedCanvas, $canvas);
    }
    public function testInverseDraw()
    {
        $canvas = [
            [' ', ' ', ' ', ' '],
            [' ', ' ', ' ', ' '],
            [' ', ' ', ' ', ' '],
        ];

        $strategy = new HorizontalStrategy();
        $strategy->draw($canvas, 3, 1, 1, 1);

        $expectedCanvas = [
            [' ', ' ', ' ', ' '],
            [' ', 'x', 'x', 'x'],
            [' ', ' ', ' ', ' '],
        ];

        $this->assertEquals($expectedCanvas, $canvas);
    }

    public function testOutCanvas()
    {
        $canvas = [
            [' ', ' ', ' ', ' '],
            [' ', ' ', ' ', ' '],
            [' ', ' ', ' ', ' '],
        ];

        $strategy = new HorizontalStrategy();
        $strategy->draw($canvas, 1, 1, 1, 3);

        $expectedCanvas = [
            [' ', ' ', ' ', ' '],
            [' ', ' ', ' ', ' '],
            [' ', ' ', ' ', ' '],
        ];
        $this->assertEquals($expectedCanvas, $canvas);
    }
}