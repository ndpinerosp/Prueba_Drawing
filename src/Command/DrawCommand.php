<?php

namespace App\Command;

use App\Factory\CommandFactory;
use App\Factory\StrategyFactory;
use App\Service\CanvasServ;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;

class DrawCommand extends Command
{

    private CommandFactory $commandFactory;
    private StrategyFactory $strategyFactory;
    private CanvasServ $canvasService;

    public function __construct(CommandFactory $commandFactory, StrategyFactory $strategyFactory, CanvasServ $canvasService)
    {
        parent::__construct();
        $this->commandFactory = $commandFactory;
        $this->strategyFactory = $strategyFactory;
        $this->canvasService = $canvasService;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Dibuja los comandos desde un archivo')
            ->addArgument('input', InputArgument::REQUIRED, 'Ruta archivo input')
            ->addArgument('output', InputArgument::REQUIRED, 'Ruta archivo output');
    }

    public function executeFile(string $inputFile, string $outputFile): void
    {
        $commands = file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $canvasOutput = '';

        foreach ($commands as $command) {
            $parts = explode(' ', $command);
            $cmd = $parts[0];
            
            $commandObject = $this->commandFactory->createCommand($cmd, array_slice($parts, 1));
            if ($commandObject) {
                $commandObject->execute();
            } else {
                throw new \RuntimeException("Comando desconocido: $cmd");
            }

            $canvasOutput .= $this->canvasService->getCanvas() . "\n";
        }

        file_put_contents($outputFile, $canvasOutput);
    }
}