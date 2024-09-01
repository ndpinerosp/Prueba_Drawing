<?php

namespace App\Service;

use App\Factory\StrategyFactory;
use App\Strategy\ICanvasStrategy;
use Symfony\Contracts\Translation\TranslatorInterface;

class CanvasServ
{
    private array $canvas = [];
    private ?ICanvasStrategy $lineStrategy = null;
    private array $errors = [];
    private TranslatorInterface $translator;
    
    public function __construct(TranslatorInterface $translator) 
    {
        $this->translator = $translator;
    }

    public function createCanvas(int $width, int $height): void
    {
        
        try {
            $this->errors = [];

            if ($width <= 0 || $height <= 0) {
                throw new \ErrorException($this->translator->trans("invalidDimensions"));
            }

            $this->canvas = array_fill(0, $height + 2, array_fill(0, $width + 2, ' '));
            $this->canvas[0] = array_fill(0, $width + 2, '-');
            $this->canvas[$height + 1] = array_fill(0, $width + 2, '-');

            for ($i = 1; $i <= $height; $i++) {
                $this->canvas[$i][0] = '|';
                $this->canvas[$i][$width + 1] = '|';
            }
        } catch (\Exception $e) {
            $this->errors[] = $e->getMessage();
        }
    }

    public function drawLine(int $x1, int $y1, int $x2, int $y2): void
    {
        try {

            $this->errors = [];

            if ($this->checkCanvas())
                throw new \ErrorException($this->translator->trans("canvasNotCreated"));

            if (!$this->areCoordinatesValid($x1, $y1, $x2, $y2)) {
                throw new \ErrorException($this->translator->trans("coordinatesOut"));
            }
            if ($x1 === $x2 && $y1 === $y2) {
                throw new \ErrorException($this->translator->trans("samePoints"));
            }

            $this->setLineStrategy(
                $y1 === $y2 ? "H" : ($x1 === $x2 ? "V" : "N")  // mira que estrategia tomar
            );

            if ($this->lineStrategy === null) {
                throw new \ErrorException($this->translator->trans("invalidLine"));
            } else {
                $this->lineStrategy->draw($this->canvas, $x1, $y1, $x2, $y2);
            }
        } catch (\Exception $e) {
            $this->errors[] = $e->getMessage();
        }
    }

    public function bucketFill(int $x, int $y, string $color): void
    {
        try {
            $this->errors = [];

            if ($this->checkCanvas())
            throw new \ErrorException($this->translator->trans("canvasNotCreated"));


            if (!$this->areCoordinatesValid($x, $y) || $this->restrictBorder($x, $y)) {
                throw new \ErrorException($this->translator->trans("pointOut"));
            }

            $width = count($this->canvas[0]);
            $height = count($this->canvas);
            $targetColor = $this->canvas[$y][$x];

            if ($targetColor === $color) {
                return;
            }

            $this->fill($x, $y, $targetColor, $color, $width, $height);
        } catch (\Exception $e) {
            $this->errors[] = $e->getMessage();
        }
    }

    private function fill(int $x, int $y, string $targetColor, string $color, int $width, int $height): void
    {

        $stack = [[$x, $y]];

        while ($stack) {
            [$auxX, $auxY] = array_pop($stack);

            if ($this->outLimits($auxX, $auxY, $width, $height) || $this->canvas[$auxY][$auxX] !== $targetColor) {  //verifica los limites y si debe pintarse
                continue;
            }

            $this->canvas[$auxY][$auxX] = $color;

            //se añaden a los vecinos a la pila
            $stack[] = [$auxX + 1, $auxY];
            $stack[] = [$auxX - 1, $auxY];
            $stack[] = [$auxX, $auxY + 1];
            $stack[] = [$auxX, $auxY - 1];
        }
    }

    public function setLineStrategy(string $strategy): void
    {
        $this->lineStrategy = StrategyFactory::createStrategy($strategy);
    }

    public function getCanvas(): string
    {

        $canvasS = implode("\n", array_map(fn($row) => implode('', $row), $this->canvas));
        if (!empty($this->errors)) {
            $canvasS .= "\n\nErrores:\n" . implode("\n", $this->errors);
        }
        return $canvasS;
    }

    private function checkCanvas(): bool
    {
        return (empty($this->canvas) || !isset($this->canvas[0]));
    }


    private function areCoordinatesValid(int $x1, int $y1, ?int $x2 = null, ?int $y2 = null): bool
    {
        $width = count($this->canvas[0]);
        $height = count($this->canvas);

        $inBounds = $x1 >= 0 && $x1 < $width && $y1 >= 0 && $y1 < $height;
        if ($x2 !== null && $y2 !== null) {
            $inBounds = $inBounds && $x2 >= 0 && $x2 < $width && $y2 >= 0 && $y2 < $height;
        }

        return $inBounds && !$this->restrictBorder($x1, $y1) && ($x2 === null || !$this->restrictBorder($x2, $y2));
    }

    private function outLimits(int $x, int $y, int $width, int $height): bool
    {
        return $x < 0 || $x >= $width - 1 || $y < 0 || $y >= $height - 1;
    }

    private function restrictBorder(int $x, int $y): bool
    {
        return $x === 0 || $x === count($this->canvas[0]) - 1 || $y === 0 || $y === count($this->canvas) - 1;
    }

    public function addError(string $message): void
    {
        $this->errors[] = $message;
    }
}
