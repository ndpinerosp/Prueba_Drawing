<?php

namespace App\Command;

use App\Service\CanvasServ;

class BucketFillCommand implements ICommand
{
    private CanvasServ $canvasService;
    private int $x, $y;
    private string $color;

    public function __construct(CanvasServ $canvasService, int $x, int $y, string $color)
    {
        $this->canvasService = $canvasService;
        $this->x = $x;
        $this->y = $y;
        $this->color = $color;
    }

    public function execute(): void
    {
        $this->canvasService->bucketFill($this->x, $this->y,$this->color);

    }
}