<?php


namespace App\Pages;


use App\Repository\CategoryPropertyRepository;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Repository\TypeListRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Response;
use Slim\Views\Twig;

class ProductPage
{
    private $twig;
    private $categoryRepository;
    private $productRepository;
    private $pageHelpers;
    private $typeListRepository;
    private $categoryPropertyRepository;

    public function __construct(
        Twig $twig,
        CategoryRepository $categoryRepository,
        PageHelpers $pageHelpers,
        ProductRepository $productRepository,
        TypeListRepository $typeListRepository,
        CategoryPropertyRepository $categoryPropertyRepository
    )
    {
        $this->twig = $twig;
        $this->categoryRepository = $categoryRepository;
        $this->pageHelpers = $pageHelpers;
        $this->productRepository = $productRepository;
        $this->typeListRepository = $typeListRepository;
        $this->categoryPropertyRepository = $categoryPropertyRepository;
    }

    public function get(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $parentId = $args['id'];
        $filterCurrCat = ['id' => $parentId];
        $currCategoryName = $this->categoryRepository->getFilteredCategory($filterCurrCat);
        $categoryName = $currCategoryName[0]['name'];

        $breadcrumb = $this->pageHelpers->getBreadCrumbs($parentId);
        $categoryProperty = $this->categoryPropertyRepository->getCategoryPropertyById($parentId);

        $typeListFilter = ['id' => $categoryProperty[0]['type']];
        $typeList = $this->typeListRepository->getFilteredTypeList($typeListFilter);

        $productFilter = ['category_id' => $parentId];
        $products = $this->productRepository->getFilteredProducts($productFilter);

        $data = $this->twig->fetch('products.twig', [
            'title' => 'Парсер "Металлл - Сервис"',
            'products' => $products,
            'categoryName' => $categoryName,
            'breadCrumbs' => $breadcrumb,
            'typeList' => $typeList[0]
        ]);
        return new Response(
            200,
            new Headers(['Content-Type' => 'text/html']),
            (new StreamFactory())->createStream($data)
        );
    }
}