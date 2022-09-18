<?php


namespace App\Controllers\ParsersHelpers;


use App\Parsers\ProductParser;
use App\Repository\CategoryPropertyRepository;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Repository\TypeListRepository;

class ProductHelper
{
    Private $productRepository;
    Private $categoryRepository;
    Private $categoryPropertyRepository;
    Private $productParser;

    public function __construct(
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository,
        CategoryPropertyRepository $categoryPropertyRepository,
        ProductParser $productParser
    )
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->categoryPropertyRepository = $categoryPropertyRepository;
        $this->productParser = $productParser;
    }

    private function getProductCategoryList() : array
    {
        $productCategories = [];
        $allCategories = $this->categoryRepository->getAllCategories();
        foreach ($allCategories as $category)
        {
            $categoryId = $category['id'];
            $filterArr = [
                'parent' => $categoryId
            ];
            $parentCategory = $this->categoryRepository->getFilteredCategory($filterArr);
            if(empty($parentCategory))
            {
                $typeList = $this->categoryPropertyRepository->getCategoryPropertyById($category['id']);

                $categoryUnit = [
                    'id' => $category['id'],
                    'link' => $category['link'].'/PageAll/1',
                    'type' => $typeList[0]['type'],
                    'name' => $category['name'],
                ];

                if(empty($typeList))
                {
                    $categoryType = $this->productParser->getTypeCategory($category);

                    if($categoryType)
                    {
                        $createArr = [
                            'category_id' => $category['id'],
                            'type' => $categoryType['id']
                        ];

                        $this->categoryPropertyRepository->createProperty($createArr);
                    }

                    $categoryUnit['type'] = $categoryType['id'];
                }

                if(!empty($categoryUnit['type']))
                {
                    $productCategories[] = $categoryUnit;
                }

            }
        }
        return $productCategories;
    }

    public function processingProducts()
    {
        $productsLinks = $this->getProductCategoryList();

        $countCreated = 0;
        $countUpdated = 0;

        foreach ($productsLinks as $productsLinkItem)
        {
            $products = $this->productParser->getProducts($productsLinkItem);
            if(!empty($products))
            {
                foreach ($products as $product)
                {
                    $processingResult = $this->createOrUpdateProduct($product);
                    if($processingResult == 'updated')
                    {
                        $countUpdated++;
                    }
                    else
                    {
                        $countCreated++;
                    }
                }
            }
        }

        $stringResult = 'На момент: '.date('m-d-Y H:i:s').',парсинг завершен. Обновлено '.$countUpdated.', Создано: '.$countCreated;
        print_r($stringResult);
    }

    private function checkProduct(array $product)
    {
        $filter = [
            'name' => $product['name'],
            'category_id' => $product['category_id'],
            'site_id' => $product['site_id'],
            'param_one' => $product['param_one'],
            'param_two' => $product['param_two'],
            'param_three' => $product['param_three'],
        ];

        $resultCheck = $this->productRepository->getFilteredProducts($filter);

        if(!empty($resultCheck))
        {
            return $resultCheck;
        }

        return false;
    }

    private function createOrUpdateProduct(array $product)
    {
        $checkResult = $this->checkProduct($product);
        if($checkResult)
        {
            $priceOne = $checkResult[0]['price_one'];
            $priceTwo = $checkResult[0]['price_two'];
            $id = $checkResult[0]['id'];

            if(($product['price_one'] != $priceOne) || ($product['price_two'] != $priceTwo))
            {
                $filterArr = ['id' => $id];
                $updateArr = [
                    'price_one' => $product['price_one'],
                    'price_two' => $product['price_two'],
                    'date_update' => $product['date_update']
                ];
                $this->productRepository->updateProduct($filterArr,$updateArr);

            }

            return 'updated';
        }
        else
        {
            $this->productRepository->createProduct($product);
            return 'created';
        }
    }

}