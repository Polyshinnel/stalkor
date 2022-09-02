<?php


namespace App\Jobs;


use simplehtmldom\HtmlWeb;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ParseCategory extends Command
{
    protected function configure()
    {
        $this->setName('parse:Category')
            ->setDescription('Парсер категорий')
            ->setHelp('Запускает парсер категорий');
    }

    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        $client = new HtmlWeb();
        $html = $client->load('https://mc.ru/products');

        $linkArr = [];
        $rowLinksObj = $html->find('.productsMenuBlock h3 a');

        foreach ($rowLinksObj as $item)
        {
            $catArr = [
                'name' => $item->plaintext,
                'link' => $item->href
            ];
            $linkArr[] = $catArr;
        }

        print_r($linkArr);

        return Command::SUCCESS;
    }
}