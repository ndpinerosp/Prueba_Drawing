<?php

namespace App\Validation;

class CommandParamsValidation
{

    public function validate(array $params, int $expCount, array $expTypes, string $command): void
    {
        if (count($params) !== $expCount) {
            throw new \InvalidArgumentException("Comando $command : Número incorrecto de parámetros. Se esperaban $expCount parámetros.");
        }
        //dd( );
        foreach ($params as $index => $param) {
            $expType = $expTypes[$index];
            //dd((filter_var($param,FILTER_VALIDATE_INT)));
            if (!$this->validateType($param, $expType)) {
                throw new \InvalidArgumentException(" Comando $command : Tipo de parámetro incorrecto en el índice $index. Se esperaba un $expType.");
            }
        }
    }

    private function validateType($param, string $expType): bool
    {
        switch ($expType) {
            case 'int':
                return is_int(filter_var($param, FILTER_VALIDATE_INT));
            case 'string':
                return is_string($param);
            default:
                return false;
        }
    }
}
