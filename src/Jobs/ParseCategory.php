<?php


namespace App\Jobs;


use App\Controllers\ParsersHelpers\CategoryHelper;
use App\Controllers\ParsersHelpers\ProductHelper;
use App\Parsers\CategoryParser;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ParseCategory extends Command
{
    private $categoryHelper;
    private $categoryParser;

    public function __construct(CategoryHelper $categoryHelper,CategoryParser $categoryParser,string $name = null)
    {
        parent::__construct($name);
        $this->categoryHelper = $categoryHelper;
        $this->categoryParser = $categoryParser;
    }

    protected function configure()
    {
        $this->setName('parse:Category')
            ->setDescription('Парсер категорий')
            ->setHelp('Запускает парсер категорий');
    }

    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        $categoryLinks = $this->categoryParser->getRootCategories();
        $this->categoryHelper->categoryProcessing($categoryLinks);
        return Command::SUCCESS;
    }
}