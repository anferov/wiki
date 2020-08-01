<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/swagger/{token}", name="swagger_config" ,requirements={"token"=".+"})
 */
class SwaggerController extends AbstractController
{
    /**
     * @var Filesystem
     */
    private Filesystem $filesystem;

    private string $publicDir;

    public function __construct(Filesystem $filesystem, $kernelPublicDir)
    {
        $this->filesystem = $filesystem;
        $this->publicDir = $kernelPublicDir;
    }

    public function __invoke(string $token = '/')
    {
        return new BinaryFileResponse(
            new \SplFileInfo($this->publicDir . DIRECTORY_SEPARATOR . $token),
            Response::HTTP_OK,
            ["Access-Control-Allow-Origin" => "*"]);
    }
}
