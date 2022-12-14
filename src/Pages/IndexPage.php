<?php


namespace App\Pages;

use App\Repository\CategoryRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Response;
use Slim\Views\Twig;

class IndexPage
{
    private $twig;
    private $categoryRepository;
    private $pageHelpers;

    public function __construct(Twig $twig,CategoryRepository $categoryRepository,PageHelpers $pageHelpers)
    {
        $this->twig = $twig;
        $this->categoryRepository = $categoryRepository;
        $this->pageHelpers = $pageHelpers;
    }

    public function get(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $categoryFilter = ['parent' => 0];

        $categoryData = $this->pageHelpers->getClearCategory($categoryFilter);

        $data = $this->twig->fetch('index.twig', [
            'title' => 'Парсер "Металлл - Сервис"',
            'categories' => $categoryData
        ]);

        return new Response(
            200,
            new Headers(['Content-Type' => 'text/html']),
            (new StreamFactory())->createStream($data)
        );
    }
}