<?php


namespace App\Parsers;


use App\Repository\TypeListRepository;
use Exception;
use simplehtmldom\HtmlWeb;

class ProductParser
{
    private $typeListRepository;

    public function __construct(TypeListRepository $typeListRepository)
    {
        $this->typeListRepository = $typeListRepository;
    }

    public function getTypeCategory(array $categoryUnit)
    {
        $link = $categoryUnit['link'];
        $client = new HtmlWeb();

        $rawTitle = [];
        $clearTitle = [];

        $typeArr = [
            'Размер',
            'Марка',
            'Длина',
            'Поверхность',
            'Секций',
            'Ру',
            'Бренд',
            'Примечание'
        ];

        //Задаем нормальный порядок
        $typeList = [
            ['Размер','Марка','Длина'],
            ['Размер','Марка','Поверхность'],
            ['Размер','Ру','Длина'],
            ['Размер','Секций','Длина'],
            ['Размер','Бренд','Примечание'],
        ];

        $html = $client->load($link);

        //Получаем весь header table, он состоит из ссылок и статических надписей
        $headerListLinks = $html->find('.excludeMobile');
        foreach ($headerListLinks as $header)
        {
            $name = $header->plaintext;
            $rawTitle[] = $name;
        }

        $headerListLinks = $html->find('.submenu a');
        foreach ($headerListLinks as $header)
        {
            $name = $header->plaintext;
            $rawTitle[] = $name;
        }

        //Перебираем все данные по заданному массиву
        foreach ($rawTitle as $rawUnit)
        {
            if(in_array($rawUnit,$typeArr))
            {
                $clearTitle[] = $rawUnit;
            }
        }

        //Ищем совпадения с шаблоном(отсутствуют корректные способы получить позиции в заданном порядке
        foreach ($typeList as $typeListUnit)
        {
            $arrDiff = array_diff($typeListUnit,$clearTitle);
            if(empty($arrDiff))
            {
                $clearTitle = $typeListUnit;
            }
        }

        $filter = [
            'column_one' => $clearTitle[0],
            'column_two' => $clearTitle[1],
            'column_three' => $clearTitle[2]
        ];

        $resultTypeTable = $this->typeListRepository->getFilteredTypeList($filter);

        if(!empty($resultTypeTable))
        {
            return $resultTypeTable[0];
        }

        return false;
    }

    public function getProducts(array $categoryUnit)
    {
        $categoryId = $categoryUnit['id'];
        $link = $categoryUnit['link'];

        $client = new HtmlWeb();
        $html = $client->load($link);
        $clearDataArr = [];

        if($html != NULL)
        {
            $rawDataTableRows = $html->find('.catalogTable tr');
            $rawCatalogArr = [];

            foreach ($rawDataTableRows as $dataTableRow)
            {
                $dataTableRowArr = [];
                $siteIdProduct = $dataTableRow->idt;

                $dataTableCeils = $dataTableRow->find('td');
                foreach ($dataTableCeils as $dataTableCeil)
                {
                    $dataTableRowArr[] = $dataTableCeil->plaintext;
                }

                $rawCatalogArr[$siteIdProduct] = $dataTableRowArr;
            }



            //Нормализуем сырые данные:
            foreach ($rawCatalogArr as $key => $rawCatalogItem){
                if(!empty($rawCatalogItem[0]) && (!empty($rawCatalogItem[6]) || !empty($rawCatalogItem[7])))
                {
                    $clearDataUnit = [
                        'name' => $rawCatalogItem[0],
                        'category_id' => $categoryId,
                        'site_id' => $key,
                        'param_one' => !empty($rawCatalogItem[1]) ? $rawCatalogItem[1] : NULL,
                        'param_two' => !empty($rawCatalogItem[2]) ? $rawCatalogItem[2] : NULL,
                        'param_three' => !empty($rawCatalogItem[3]) ? $rawCatalogItem[3] : NULL,
                        'price_one' => !empty($rawCatalogItem[6]) ? $rawCatalogItem[6] : NULL,
                        'price_two' => !empty($rawCatalogItem[7]) ? $rawCatalogItem[7] : NULL,
                        'date_update' => date('Y-m-d H:i:s')
                    ];

                    $clearDataArr[] = $clearDataUnit;
                }
            }
        }
        else
        {
            $errMsg = 'Не смог обработать категорию: '.$categoryUnit['name'];
            print_r($errMsg);
        }




        return $clearDataArr;
    }

}