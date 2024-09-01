<?php

namespace App\Command;

use App\Service\CanvasServ;


class CreateCanvasCommand implements ICommand
{
    private CanvasServ $canvasService;
    private int $width, $height;

    public function __construct(CanvasServ $canvasService, int $w, int $h)
    {
        $this->canvasService = $canvasService;
        $this->width = $w;
        $this->height = $h;
    }

    public function execute(): void
    {
        $this->canvasService->createCanvas($this->width, $this->height);
    }
}
