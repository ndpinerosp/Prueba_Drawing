<?php

namespace App\Factory;

use App\Strategy\ICanvasStrategy;
use App\Strategy\HorizontalStrategy;
use App\Strategy\VerticalStrategy;

class StrategyFactory
{
    public static function createStrategy(string $lineType): ?ICanvasStrategy
    {
        switch ($lineType) {
            case 'H':
                return new HorizontalStrategy();
            case 'V':
                return new VerticalStrategy();
            default:
                return null;
        }
    }
}