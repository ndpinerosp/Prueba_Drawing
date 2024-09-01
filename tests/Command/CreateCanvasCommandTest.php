<?php

namespace App\Tests\Command;

use App\Command\CreateCanvasCommand;
use App\Service\CanvasServ;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class CreateCanvasCommandTest extends TestCase
{
    private MockObject $canvasServiceMock;
    private CreateCanvasCommand $command;

    protected function setUp(): void
    {
        $this->canvasServiceMock = $this->createMock(CanvasServ::class);

        $this->command = new CreateCanvasCommand($this->canvasServiceMock, 100, 50);
    }

    public function testExecute(): void
    {
        $this->canvasServiceMock
            ->expects($this->once())
            ->method('createCanvas')
            ->with(100, 50);

        $this->command->execute();
    }

    public function testInvalidArgumentExecute(): void   //valida el numero de argumentos
    {
        $this->expectException(\ArgumentCountError::class);


        new CreateCanvasCommand($this->canvasServiceMock, 10);
    }
    
    public function testInvalidTypeExecute(): void //valida el tipo de argumentos
    {
        $this->expectException(\TypeError::class);

        new CreateCanvasCommand($this->canvasServiceMock, 10, "prueba");
    }
}
