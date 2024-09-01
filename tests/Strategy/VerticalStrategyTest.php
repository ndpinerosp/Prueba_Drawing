<?php

namespace App\Tests\Strategy;

use App\Strategy\VerticalStrategy;
use PHPUnit\Framework\TestCase;

class VerticalStrategyTest extends TestCase
{
    public function testDraw()
    {
        $canvas = [
            [' ', ' ', ' '],
            [' ', ' ', ' '],
            [' ', ' ', ' '],
            [' ', ' ', ' '],
            [' ', ' ', ' '],
        ];

        $strategy = new VerticalStrategy();
        $strategy->draw($canvas, 2, 1, 2, 3);

        $expectedCanvas = [
            [' ', ' ', ' '],
            [' ', ' ', 'x'],
            [' ', ' ', 'x'],
            [' ', ' ', 'x'],
            [' ', ' ', ' '],
        ];

        $this->assertEquals($expectedCanvas, $canvas);
    }

    public function testInverseDraw()
    {
        $canvas = [
            [' ', ' ', ' '],
            [' ', ' ', ' '],
            [' ', ' ', ' '],
            [' ', ' ', ' '],
            [' ', ' ', ' '],
        ];

        $strategy = new VerticalStrategy();
        $strategy->draw($canvas, 2, 3, 2, 1);

        $expectedCanvas = [
            [' ', ' ', ' '],
            [' ', ' ', 'x'],
            [' ', ' ', 'x'],
            [' ', ' ', 'x'],
            [' ', ' ', ' '],
        ];

        $this->assertEquals($expectedCanvas, $canvas);
    }

    public function testOutCanvas()
    {
        $canvas = [
            [' ', ' ', ' '],
            [' ', ' ', ' '],
            [' ', ' ', ' '],
            [' ', ' ', ' '],
            [' ', ' ', ' '],
        ];

        $strategy = new VerticalStrategy();
        $strategy->draw($canvas, 0, 1, 5, 1);

        $expectedCanvas = [
            [' ', ' ', ' '],
            [' ', ' ', ' '],
            [' ', ' ', ' '],
            [' ', ' ', ' '],
            [' ', ' ', ' '],
        ];
        $this->assertEquals($expectedCanvas, $canvas);
    }

   
}
