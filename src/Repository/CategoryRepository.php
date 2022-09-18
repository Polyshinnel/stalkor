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

    public function getAllCategories()
    {
        return $this->category->all()->toArray();
    }

    public function getAllCategoriesWithType()
    {
        return $this->category::select(
            'categories.id as category_id',
            'categories.name',
            'categories.parent',
            'categories.link',
            'category_property.type'
        )
            ->leftjoin('category_property','categories.id','=','category_property.category_id')
            ->get()
            ->toArray();
    }
}