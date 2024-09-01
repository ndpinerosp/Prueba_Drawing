<?php

namespace App\Strategy;

class HorizontalStrategy implements ICanvasStrategy
{
    public function draw(array &$canvas, int $x1, int $y1, int $x2, int $y2): void
    {
        $maxX = count($canvas[0]) - 1; 
        $maxY = count($canvas) - 1;     

        
        if ($y1 < 0 || $y1 > $maxY || $x1 < 0 || $x1 > $maxX || $x2 < 0 || $x2 > $maxX || $y2 < 0 || $y2 > $maxY) {
            return; 
        }

        
        for ($x = min($x1, $x2); $x <= max($x1, $x2); $x++) {
            $canvas[$y1][$x] = 'x';
        }
    }
}