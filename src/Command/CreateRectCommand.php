<?php

namespace App\Command;

use App\Service\CanvasServ;
use App\Validation\RectangleValidation;

class CreateRectCommand implements ICommand
{
    private CanvasServ $canvasService;
    private RectangleValidation $validator;
    private int $x1, $y1, $x2, $y2;


    public function __construct(CanvasServ $canvasService,RectangleValidation $validator , int $x1, int $y1, int $x2, int $y2)
    {
        $this->canvasService = $canvasService;
        $this->validator = $validator;
        $this->x1 = $x1;
        $this->y1 = $y1;
        $this->x2 = $x2;
        $this->y2 = $y2;
    }

    public function execute(): void
    {
        if (!$this->validator->validate($this->x1, $this->y1, $this->x2, $this->y2)) {
            $this->canvasService->addError($this->validator->getErrorMessage());
            return;
        }
        $this->canvasService->drawLine($this->x1, $this->y1, $this->x2, $this->y1); // Arriba
        $this->canvasService->drawLine($this->x2, $this->y1, $this->x2, $this->y2); // Derecha
        $this->canvasService->drawLine($this->x2, $this->y2, $this->x1, $this->y2); // Abajo
        $this->canvasService->drawLine($this->x1, $this->y2, $this->x1, $this->y1); // Izquierda
    }
    
}
