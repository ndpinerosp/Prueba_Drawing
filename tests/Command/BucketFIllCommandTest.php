<?php

namespace App\Tests;

use App\Command\BucketFillCommand;
use PHPUnit\Framework\TestCase;
use App\Service\CanvasServ;
use PHPUnit\Framework\MockObject\MockObject;

class BucketFillCommandTest extends TestCase
{
    private MockObject $canvasServiceMock;
    private BucketFillCommand $command;

    protected function setUp(): void
    {
        $this->canvasServiceMock = $this->createMock(CanvasServ::class);

        $this->command = new BucketFillCommand($this->canvasServiceMock, 10, 12, "c");
    }

    public function testExecute(): void
    {
        $this->canvasServiceMock
            ->expects($this->once())
            ->method('bucketFill')
            ->with(10, 12,"c");

        $this->command->execute();
    }

    public function testInvalidArgumentExecute(): void   //valida el numero de argumentos
    {
        $this->expectException(\ArgumentCountError::class);


        new BucketFillCommand($this->canvasServiceMock, 10,12);
    }
    
    public function testInvalidTypeExecute(): void //valida el tipo de argumentos
    {
        $this->expectException(\TypeError::class);

        new BucketFillCommand($this->canvasServiceMock, 10,"A", 12);
    }
}
