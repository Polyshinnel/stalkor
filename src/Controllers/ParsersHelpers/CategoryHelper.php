<?php


namespace App\Controllers\ParsersHelpers;


use App\Repository\CategoryRepository;

class CategoryHelper
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function categoryProcessing(array $categoryArr) : void
    {
        foreach ($categoryArr as $categoryUnit)
        {
            $parentId = 0;
            $checkCat = $this->checkExistCategory($categoryUnit);
            if($checkCat)
            {
                $parentId = $checkCat[0]['id'];

                //Проверяем наличие подкатегорий первого уровня
                if(isset($categoryUnit['child_1']))
                {
                    $childFirstLevel = $categoryUnit['child_1'];
                    foreach ($childFirstLevel as $childFirstLevelArr)
                    {
                        $checkSubCat = $this->checkExistCategory($childFirstLevelArr);
                        if($checkSubCat)
                        {
                            $parentId = $checkSubCat[0]['id'];

                            //Проверяем наличие подкатегорий второго уровня
                            if(isset($childFirstLevelArr['child_2']))
                            {
                                $childSecondLevel = $childFirstLevelArr['child_2'];
                                foreach ($childSecondLevel as $childSecondLevelArr)
                                {
                                    $checkSubSubCat = $this->checkExistCategory($childSecondLevelArr);
                                    if($checkSubSubCat)
                                    {
                                        $parentId = $checkSubSubCat[0]['id'];
                                    }
                                    else
                                    {
                                        $this->createCategory($childSecondLevelArr,$parentId);
                                    }
                                }
                            }


                        }
                        else
                        {
                            $this->createCategory($childFirstLevelArr,$parentId);
                        }
                    }
                }

            }
            else
            {
                $this->createCategory($categoryUnit,$parentId);
            }
        }
    }

    private function checkExistCategory(array $categoryUnit)
    {
        $filterArr = [
            'name' => $categoryUnit['name'],
            'link' => $categoryUnit['link']
        ];

        $categoryData = $this->categoryRepository->getFilteredCategory($filterArr);

        if(!empty($categoryData))
        {
            return $categoryData;
        }

        return false;
    }

    private function createCategory(array $categoryUnit,int $parentId)
    {
        $createArr = [
            'name' => $categoryUnit['name'],
            'parent' => $parentId,
            'link' => $categoryUnit['link']
        ];
        $this->categoryRepository->createCategory($createArr);
    }
}