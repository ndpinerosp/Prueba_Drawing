<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Command\CreateLineCommand;
use App\Service\CanvasServ;
use PHPUnit\Framework\MockObject\MockObject;

class CreateLineCommandTest extends TestCase
{
    private MockObject $canvasServiceMock;
    private CreateLineCommand $command;

    protected function setUp(): void
    {
        $this->canvasServiceMock = $this->createMock(CanvasServ::class);

        $this->command = new CreateLineCommand($this->canvasServiceMock, 5,1,2,1);
    }

    public function testExecute(): void
    {
        $this->canvasServiceMock
            ->expects($this->once())
            ->method('drawLine')
            ->with(5,1,2,1);

        $this->command->execute();
    }

    public function testInvalidArgumentExecute(): void   //valida el numero de argumentos
    {
        $this->expectException(\ArgumentCountError::class);


        new CreateLineCommand($this->canvasServiceMock, 10, 11, 2);
    }
    
    public function testInvalidTypeExecute(): void //valida el tipo de argumentos
    {
        $this->expectException(\TypeError::class);

        new CreateLineCommand($this->canvasServiceMock, 10, 1,1,"A");
    }
}
