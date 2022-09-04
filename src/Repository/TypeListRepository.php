<?php


namespace App\Repository;


use App\Models\TypeList;

class TypeListRepository
{
    private $typeList;

    public function __construct(TypeList $typeList)
    {
        $this->typeList = $typeList;
    }

    public function getTypeListById(int $id) : array
    {
        return $this->typeList->where('id',$id)->get()->toArray();
    }

    public function getAllTypeList() : array
    {
        return $this->typeList->all()->toArray();
    }

    public function createTypeList(array $arr) : void
    {
        $this->typeList->create($arr);
    }
}