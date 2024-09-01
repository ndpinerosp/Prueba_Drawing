<?php
namespace App\Validation;

class RectangleValidation {

    private string $errorMessage = '';

    public function validate(int $x1, int $y1, int $x2, int $y2): bool
    {
        if ($x1 === $x2 || $y1 === $y2) {
            $this->errorMessage = "Las coordenadas no forman un rectángulo válido.";
            return false;
        }

        $width = abs($x2 - $x1);
        $height = abs($y2 - $y1);

        if ($width <= 0 || $height <= 0) {
            $this->errorMessage = "Las coordenadas no forman un rectángulo válido.";
            return false;
        }

        return true;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }
}