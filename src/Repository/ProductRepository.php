<?php


namespace App\Repository;


use App\Models\Product;

class ProductRepository
{
    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function getFilteredProducts(array $filter)
    {
        return $this->product->where($filter)->get()->toArray();
    }

    public function createProduct(array $createArr) : void
    {
        $this->product->create($createArr);
    }

    public function updateProduct(array $filterArr,array $updateArr) : void
    {
        $this->product->where($filterArr)->update($updateArr);
    }
}