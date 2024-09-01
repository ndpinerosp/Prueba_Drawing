<?php

namespace App\Tests\Factory;


use App\Factory\StrategyFactory;
use App\Strategy\ICanvasStrategy;
use App\Strategy\HorizontalStrategy;
use App\Strategy\VerticalStrategy;
use PHPUnit\Framework\TestCase;

class StrategyFactoryTest extends TestCase
{
    public function testHorizontalStrategy()
    {
        $strategy = StrategyFactory::createStrategy('H');
        $this->assertInstanceOf(HorizontalStrategy::class, $strategy);
    }

    public function testVerticalStrategy()
    {
        $strategy = StrategyFactory::createStrategy('V');
        $this->assertInstanceOf(VerticalStrategy::class, $strategy);
    }

    public function testCreateInvalidStrategy()
    {
        $strategy = StrategyFactory::createStrategy('Y');
        $this->assertNull($strategy);
    }
}
