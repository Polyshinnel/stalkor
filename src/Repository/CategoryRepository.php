<?php


namespace App\Repository;


use App\Models\Category;

class CategoryRepository
{
    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function createCategory(array $createArr) : void
    {
        $this->category->create($createArr);
    }

    public function getFilteredCategory($filter)
    {
        return $this->category->where($filter)->get()->toArray();
    }
}