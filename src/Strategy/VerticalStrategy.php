<?php

namespace App\Strategy;

class VerticalStrategy implements ICanvasStrategy
{
    public function draw(array &$canvas, int $x1, int $y1, int $x2, int $y2): void
    {
        $maxX = count($canvas[0]) - 1; 
        $maxY = count($canvas) - 1;    

        if ($x1 < 0 || $x1 > $maxX || $y1 < 0 || $y1 > $maxY || $x2 < 0 || $x2 > $maxX || $y2 < 0 || $y2 > $maxY) { //validaa si esat fuera del canvas
            return; 
        }

        for ($y = min($y1, $y2); $y <= max($y1, $y2); $y++) {
            $canvas[$y][$x1] = 'x';
        }
        
    }
}