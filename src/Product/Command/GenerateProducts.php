<?php

declare(strict_types=1);

namespace App\Product\Command;


use App\Product\Domain\Manager\ProductManager;
use App\Product\Domain\Model\Product;
use App\Product\Infrastructure\Doctrine\Main\Repository\ProductRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateProducts extends Command
{
    protected static $defaultName = 'app:generate-products';

    private ProductRepository $productManager;

    public function __construct(ProductRepository $productManager)
    {
        $this->productManager = $productManager;
        parent::__construct();
    }


    protected function configure()
    {
        $this
            ->setDescription('Generate 10 unique products.')
            ->setHelp('This command allows you to generate dummy products that can be activated by users...');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $generatedProducts = $this->generateRandomProductData();

        foreach ($generatedProducts as $product) {
            $this->productManager->save($product);
        }
        return $output->writeln('10 dummy products generated.');

    }

    private function generateRandomProductData(): array
    {

        $products = [];
        for ($i = 0; $i < 10; $i++) {
            $product = new Product();
            $product->setName('Product' . $i);
            $product->setSerialNumber('000-000-00' . $i);
            $product->setActivationNumber('000-000-00' . $i);
            $product->setIsActive(false);
            $product->setProductType(1);
            $products[] = $product;
        }
        return $products;
    }
}