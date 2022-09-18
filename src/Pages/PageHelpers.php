<?php


namespace App\Pages;


use App\Repository\CategoryRepository;

class PageHelpers
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getClearCategory($filter) : array
    {
        $categoryList = $this->categoryRepository->getFilteredCategory($filter);

        $categoryData = [];

        foreach ($categoryList as $categoryItem)
        {
            $parentResult = $this->getTypedCategory($categoryItem);
            $categoryItem['type'] = 'not last';

            if(!$parentResult)
            {
                $categoryItem['type'] = 'last';
            }

            $categoryData[] = $categoryItem;
        }

        return $categoryData;
    }

    private function getTypedCategory($categoryUnit)
    {
        $filter = ['parent' => $categoryUnit['id']];
        $resultParent = $this->categoryRepository->getFilteredCategory($filter);
        if(empty($resultParent))
        {
            return false;
        }

        return true;
    }

    private function getAllParent(array $rootCat,$parent)
    {
        $filter = ['id' => $parent];
        $category = $this->categoryRepository->getFilteredCategory($filter);
        if(!empty($category[0]))
        {
            $rootCat[] = $category[0];
        }
        else
        {
            return $rootCat;
        }


        if($parent == 0)
        {
            return $rootCat;
        }
        else
        {
            $newParent = $rootCat[count($rootCat)-1]['parent'];
            return $this->getAllParent($rootCat,$newParent);
        }
    }

    public function getBreadCrumbs($parent)
    {
        $rootCat = [];
        $rootCat = $this->getAllParent($rootCat,$parent);

        $breadCrumbs = [
            [
                'url' => '/',
                'name' => 'Главная'
            ]
        ];

        $rootCat = array_reverse($rootCat);
        array_pop($rootCat);

        foreach ($rootCat as $rootItem)
        {
            $breadCrumbs[] = [
                'url' => '/category/'.$rootItem['id'],
                'name' => $rootItem['name']
            ];
        }

        return $breadCrumbs;
    }
}