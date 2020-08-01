<?php

namespace App\Controller;

use App\Domain\Contract\ContentRepositoryContract;
use App\Domain\Contract\MarkdownProcessorContract;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("parser/{token}", name="parser", requirements={"token"=".+"})
 */
class ArticleController extends AbstractController
{
    /**
     * @var MarkdownProcessorContract
     */
    private MarkdownProcessorContract $parser;
    /**
     * @var ContentRepositoryContract
     */
    private ContentRepositoryContract $repository;

    public function __construct(MarkdownProcessorContract $parser, ContentRepositoryContract $repository)
    {
        $this->parser = $parser;
        $this->repository = $repository;
    }

    public function __invoke(string $token = '/')
    {
        return $this->render('article/index.html.twig', [
            'token' => $token,
            'content' => $this->parser->parse($this->repository->findMarkdownByToken($token))
        ]);
    }
}
