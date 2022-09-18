<?php /** @noinspection ALL */


namespace App\Pages;


use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Repository\TypeListRepository;
use App\Repository\UserRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Response;

class GetProducts
{
    private $userRepository;
    private $productRepository;
    private $categoryRepository;
    private $typeListRepository;

    public function __construct(
        UserRepository $userRepository,
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository,
        TypeListRepository $typeListRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->typeListRepository = $typeListRepository;
    }

    public function get(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $authData = $request->getHeader("Authorization");

        $resultAuth = $this->checkAuth($authData);
        $data = [
            'authErr' => 'Ошибка авторизации'
        ];

        $paramsArr = [
            'all_products',
            'all_categories',
            'products_categories',
            'all_types',
        ];

        if($resultAuth)
        {
            $params = $request->getParsedBody();

            $data = [
                'productsErr' => 'Параметры не распознанны'
            ];

            if(!empty($params['filter']['category_id']))
            {
                $filter = [
                    'category_id' => $params['filter']['category_id']
                ];
                $data = $this->productRepository->getFilteredProducts($filter);
            }

            if(!empty($params['filter']['params']))
            {
                $paramName = $params['filter']['params'];

                if(in_array($paramName,$paramsArr))
                {
                    if($paramName == 'all_products')
                    {
                        $data = $this->productRepository->getAllProducts();
                    }

                    if($paramName == 'products_categories')
                    {
                        $data = $this->categoryRepository->getAllCategoriesWithType();
                    }

                    if($paramName == 'all_categories')
                    {
                        $data = $this->categoryRepository->getAllCategories();
                    }

                    if($paramName == 'all_types')
                    {
                        $data = $this->typeListRepository->getAllTypeList();
                    }
                }
            }
        }

        $data = json_encode($data,JSON_UNESCAPED_UNICODE);
        return new Response(
            200,
            new Headers(['Content-Type' => 'text/html']),
            (new StreamFactory())->createStream($data)
        );
    }

    private function checkAuth($authHeader)
    {
        $authArr = explode(':',$authHeader[0]);

        if(count($authArr) < 1)
        {
            return false;
        }
        else
        {
            $login = $authArr[0];
            $pass = md5($authArr[1]);

            $authFilter = ['login' => $login,'password' => $pass];

            $authResult = $this->userRepository->getFilteredUsers($authFilter);
            if(empty($authResult))
            {
                return false;
            }
            else
            {
                return true;
            }
        }


    }
}