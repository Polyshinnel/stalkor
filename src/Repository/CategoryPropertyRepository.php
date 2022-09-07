<?php


namespace App\Repository;


use App\Models\CategoryProperty;

class CategoryPropertyRepository
{
    private $categoryProperty;

    public function __construct(CategoryProperty $categoryProperty)
    {
        $this->categoryProperty = $categoryProperty;
    }

    public function createProperty(array $createArr) : void
    {
        $this->categoryProperty->create($createArr);
    }

    public function getCategoryPropertyById(int $categoryId) : array
    {
        return $this->categoryProperty->where('category_id',$categoryId)->get()->toArray();
    }
}