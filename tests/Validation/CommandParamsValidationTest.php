<?php
use PHPUnit\Framework\TestCase;
use App\Validation\CommandParamsValidation;

class CommandParamsValidationTest extends TestCase
{
    private CommandParamsValidation $validator;

    protected function setUp(): void
    {
        $this->validator = new CommandParamsValidation();
    }

    public function testInvalidParamCount(): void   
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Comando B : Número incorrecto de parámetros. Se esperaban 2 parámetros.");

        $params = [3];
        $expCount = 2;
        $expTypes = ['int', 'string'];
        $command = 'B';

        $this->validator->validate($params, $expCount, $expTypes, $command);
    }

    public function testInvalidParamType(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Comando L : Tipo de parámetro incorrecto en el índice 1. Se esperaba un string.");

        $params = [1, 2];
        $expCount = 2;
        $expTypes = ['int', 'string'];
        $command = 'L';

        $this->validator->validate($params, $expCount, $expTypes, $command);
    }

    public function testValidParamsCanvasCommand(): void    //valida unicamente los parametros y el tipo no el comando asociado 
    {
        $params = [10, 20];
        $this->validator->validate($params, 2, ['int', 'int'], 'C');
        $this->assertTrue(true); 
    }

    public function testValidParamsBucketFillCommand(): void  //valida unicamente los parametros y el tipo no el comando asociado
    {
        $params = [5, 5, "A"];
        $this->validator->validate($params, 3, ['int','int', 'string'], 'B');
        $this->assertTrue(true); 
    }
}