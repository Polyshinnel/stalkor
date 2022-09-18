<?php


namespace App\Pages;


use App\Repository\CategoryRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Response;
use Slim\Views\Twig;

class CategoryPage
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

    public function get(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $parentId = $args['id'];
        $filter = ['parent' => $parentId];

        $categoryData = $this->pageHelpers->getClearCategory($filter);

        $filterCurrCat = ['id' => $parentId];
        $currCategoryName = $this->categoryRepository->getFilteredCategory($filterCurrCat);

        $categoryName = $currCategoryName[0]['name'];

        $breadcrumb = $this->pageHelpers->getBreadCrumbs($parentId);


        $data = $this->twig->fetch('category.twig', [
            'title' => 'Парсер "Металлл - Сервис"',
            'categories' => $categoryData,
            'categoryName' => $categoryName,
            'breadCrumbs' => $breadcrumb
        ]);
        return new Response(
            200,
            new Headers(['Content-Type' => 'text/html']),
            (new StreamFactory())->createStream($data)
        );
    }


}