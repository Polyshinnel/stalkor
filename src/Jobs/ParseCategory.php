<?php


namespace App\Jobs;


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

        return Command::SUCCESS;
    }
}