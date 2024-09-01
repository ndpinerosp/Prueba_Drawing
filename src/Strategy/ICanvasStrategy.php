<?php

namespace App\Strategy;

interface ICanvasStrategy
{
    public function draw(array &$canvas, int $x1, int $y1, int $x2, int $y2): void;
}