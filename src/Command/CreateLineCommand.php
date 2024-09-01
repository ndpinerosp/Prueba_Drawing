<?php

namespace App\Command;

use App\Service\CanvasServ;

class CreateLineCommand implements ICommand
{
    private CanvasServ $canvasService;
    private int $x1, $y1, $x2, $y2;

    public function __construct(CanvasServ $canvasService, int $x1, int $y1, int $x2, int $y2)
    {
        $this->canvasService = $canvasService;
        $this->x1 = $x1;
        $this->x2 = $x2;
        $this->y1 = $y1;
        $this->y2 = $y2;
    }

    public function execute(): void
    {
        $this->canvasService->drawLine($this->x1, $this->y1, $this->x2, $this->y2);
    }
}
