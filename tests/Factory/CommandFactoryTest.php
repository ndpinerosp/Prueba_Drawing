<?php

namespace App\Tests\Factory;

use App\Factory\CommandFactory;
use App\Command\ICommand;
use App\Command\CreateCanvasCommand;
use App\Command\CreateLineCommand;
use App\Command\CreateRectCommand;
use App\Command\BucketFillCommand;
use App\Validation\RectangleValidation;
use App\Validation\CommandParamsValidation;
use App\Service\CanvasServ;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class CommandFactoryTest extends TestCase
{
    private CommandFactory $commandFactory;
    private MockObject $canvasService;
    private MockObject $paramValidator;
    private MockObject $rectangleValidation;


    protected function setUp(): void
    {
        $this->canvasService = $this->createMock(CanvasServ::class);
        $this->paramValidator = $this->createMock(CommandParamsValidation::class);
        $this->rectangleValidation = $this->createMock(RectangleValidation::class);

        $this->commandFactory = new CommandFactory(
            $this->canvasService,
            $this->paramValidator,
            $this->rectangleValidation
        );
    }

    public function testCreateCanvasCommand(): void //valida el comando Create Canvas
    {
        $params = [10, 20];
        $this->paramValidator->expects($this->once())
            ->method('validate')
            ->with($params, 2, ['int', 'int'], 'C');

        $command = $this->commandFactory->createCommand('C', $params);
        $this->assertInstanceOf(CreateCanvasCommand::class, $command);
    }

    public function testCreateLineCommand(): void  // valida el commando Create Line
    {
        $params = [1, 2, 3, 4];
        $this->paramValidator->expects($this->once())
            ->method('validate')
            ->with($params, 4, ['int', 'int', 'int', 'int'], 'L');

        $command = $this->commandFactory->createCommand('L', $params);
        $this->assertInstanceOf(CreateLineCommand::class, $command);
    }

    public function testCreateBucketFillCommand(): void  // valida el commando Bucket Fill
    {
        $params = [1, 2, 'A'];
        $this->paramValidator->expects($this->once())
            ->method('validate')
            ->with($params, 3, ['int', 'int', 'string'], 'B');

        $command = $this->commandFactory->createCommand('B', $params);
        $this->assertInstanceOf(BucketFillCommand::class, $command);
    }

    public function testCreateRectCommand(): void // valida el commando Create Rectangle
    {
        $params = [1, 2, 3, 4];
        $this->paramValidator->expects($this->once())
            ->method('validate')
            ->with($params, 4, ['int', 'int', 'int', 'int'], 'R');

        $command = $this->commandFactory->createCommand('R', $params);
        $this->assertInstanceOf(CreateRectCommand::class, $command);
    }

    public function testInvalidCommand(): void  // valida el caso de un comando no conocido
    {
        $params = [1, 2];
        $this->paramValidator->expects($this->never())->method('validate');

        $command = $this->commandFactory->createCommand('W', $params);
        $this->assertNull($command);
    }

    public function testInvalidParams(): void  //valida en caso que la cantidad de parametros sea incorrecta
    {
        $this->expectException(\InvalidArgumentException::class);

        $params = [1, 2, 'X'];
        $this->paramValidator->expects($this->once())
            ->method('validate')
            ->with($params, 2, ['int', 'int'], 'C')
            ->will($this->throwException(new \InvalidArgumentException()));

        $this->commandFactory->createCommand('C', $params);
    }

}
