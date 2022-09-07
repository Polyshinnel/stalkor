<?php


namespace App\Jobs;


use App\Controllers\ParsersHelpers\ProductHelper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ParseProducts extends Command
{
    private $productHelper;
    private $productParser;

    public function __construct(ProductHelper $productHelper,string $name = null)
    {
        parent::__construct($name);
        $this->productHelper = $productHelper;
    }

    protected function configure()
    {
        $this->setName('parse:Products')
            ->setDescription('Парсер товаров')
            ->setHelp('Запускает парсер товаров из конечных категорий');
    }

    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        $this->productHelper->processingProducts();
        return Command::SUCCESS;
    }
}