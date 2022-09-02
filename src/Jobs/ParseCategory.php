<?php


namespace App\Jobs;


use App\Parsers\CategoryParser;
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
        $categoryParser = new CategoryParser();
        $categoryLinks = $categoryParser->getRootCategories();

        return Command::SUCCESS;
    }
}