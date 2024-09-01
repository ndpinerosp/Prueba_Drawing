<?php

namespace App\Controller;

use App\Service\CanvasServ;
use App\Command\DrawCommand;
use App\Factory\CommandFactory;
use App\Factory\StrategyFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class CanvasController extends AbstractController
{
    private CanvasServ $canvasService;
    private CommandFactory $commandFactory;
    private StrategyFactory $strategyFactory;

    public function __construct(CanvasServ $canvasService, CommandFactory $commandFactory, StrategyFactory $strategyFactory)
    {
        $this->canvasService = $canvasService;
        $this->commandFactory = $commandFactory;
        $this->strategyFactory = $strategyFactory;
    }

    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('index.html.twig');
    }



    /**
     * @Route("/upload", methods={"GET", "POST"})
     */
    public function upload(Request $request): Response
    {
        try {

            if ($request->isMethod('POST')) {
                
                $file = $request->files->get('file');

                if (!$file || !$file->isValid() || !in_array($file->getClientOriginalExtension(), ['txt'])) {

                    return $this->render('upload.html.twig', ['error' => 'Archivo Invalido. Solo se permite formato Txt ']);
                } else {

                    $outputFilePath = ' output.txt';
                    $command = new DrawCommand(
                        $this->commandFactory,
                        $this->strategyFactory,
                        $this->canvasService
                    );


                    $command->executeFile($file->getPathname(), $outputFilePath);

                    //return $this->file($outputFilePath, 'output.txt');
                    return $this->render('upload.html.twig', [
                        'message' => 'Resultado generado exitosamente.',
                        'urlDownload' => $this->generateUrl('downloadFile', ['file' => $outputFilePath])
                    ]);
                }
            }

            return $this->render('upload.html.twig');
        } catch (\Exception $e) {

            return $this->render('upload.html.twig', [
                'error' => $e->getMessage(),
            ]);
        }
    }
    /**
     * @Route("/download")
     */
    public function downloadFile(Request $request): Response
    {
        $filePath = $request->query->get('file');

        if (file_exists($filePath)) {
            return $this->file($filePath, 'output.txt');
        }

        return $this->render('error.html.twig', ['error' => 'Archivo no encontrado.']);
    }
}
