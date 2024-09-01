<?php

namespace App\Factory;

use App\Command\ICommand;
use App\Command\CreateCanvasCommand;
use App\Command\CreateLineCommand;
use App\Command\CreateRectCommand;
use App\Command\BucketFillCommand;
use App\Validation\CommandParamsValidation;
use App\Validation\RectangleValidation;
use App\Service\CanvasServ;

class CommandFactory
{
    private CanvasServ $canvasService;
    private CommandParamsValidation $paramValidator;

    public function __construct(CanvasServ $canvasService, CommandParamsValidation  $paramValidator)
    {
        $this->canvasService = $canvasService;
        $this->paramValidator = $paramValidator;
    }
    public function createCommand(string $command, array $params): ?ICommand {

        switch ($command) {
            case 'C':
                $this->paramValidator->validate($params, 2, ['int', 'int'],$command);
                return new CreateCanvasCommand($this->canvasService, (int)$params[0], (int)$params[1]);
            case 'L':
                $this->paramValidator->validate($params, 4, ['int', 'int', 'int', 'int'],$command);
                return new CreateLineCommand($this->canvasService, (int)$params[0], (int)$params[1], (int)$params[2], (int)$params[3]);
            case 'R':
                $this->paramValidator->validate($params, 4, ['int', 'int', 'int', 'int'],$command); 
                return new CreateRectCommand($this->canvasService, new RectangleValidation(),(int)$params[0], (int)$params[1], (int)$params[2], (int)$params[3]);
            case 'B':
                $this->paramValidator->validate($params, 3, ['int', 'int', 'string'],$command);
                return new BucketFillCommand($this->canvasService, (int)$params[0], (int)$params[1], $params[2]);
            default:
                return null;
        }
    }
    
}
