<?php

namespace App\Parsers;

use simplehtmldom\HtmlWeb;

class CategoryParser
{
    private $rootLink = 'https://mc.ru';

    public function getRootCategories()
    {
        $rootLink = $this->rootLink;

        $client = new HtmlWeb();
        $html = $client->load('https://mc.ru/products');

        $linkArr = [];
        $rawLinksObj = $html->find('.productsMenuBlock h3 a');

        foreach ($rawLinksObj as $item) {

            $link = $rootLink.$item->href;

            $catArr = [
                'name' => $item->plaintext,
                'link' => $link
            ];

            $child = $this->getChildCategories($client,$link);
            if(!empty($child))
            {
                $catArr['child_1'] = $child;
            }

            $linkArr[] = $catArr;
        }

        return $linkArr;


    }

    private function getChildCategories(HtmlWeb $client,$link)
    {
        $childCategoryArr = [];

        $selectorFirstLevel = '.productsh3._blue a';
        $childLevelOne = $this->getChildUnits($client,$link,$selectorFirstLevel);
        foreach ($childLevelOne as $item)
        {
            $link = $item['link'];

            $selectorChildLevelTwo = '.catalogItemList ul li a';
            $childLevelTwo = $this->getChildUnits($client,$link,$selectorChildLevelTwo);

            $razmSelector = 'ul.razm_lst a';
            $razmArr = $this->getChildUnits($client,$link,$razmSelector);

            //Удаляем из массива категорий вкладку размеры
            $arrDiff = array_diff_assoc($childLevelTwo,$razmArr);
            //Чистим дубли
            $clearArr = $this->getUniqueArr('link',$arrDiff);


            if(!empty($childLevelTwo)){
                $item['child_2'] = $clearArr;
            }

            $childCategoryArr[] = $item;
        }
        return $childCategoryArr;
    }

    private function getChildUnits(HtmlWeb $client,$link,$selector)
    {
        $html = $client->load($link);
        $rootLink = $this->rootLink;

        $linkArr = [];
        $rawLinksObj = $html->find($selector);

        foreach ($rawLinksObj as $item) {
            $catArr = [
                'name' => $item->plaintext,
                'link' => $rootLink.$item->href
            ];

            $linkArr[] = $catArr;
        }
        return $linkArr;
    }

    private function getUniqueArr($key,$arr)
    {
        $tmp = $key_array = array();
        $i = 0;

        foreach($arr as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $tmp[$i] = $val;
            }
            $i++;
        }
        return $tmp;
    }


}