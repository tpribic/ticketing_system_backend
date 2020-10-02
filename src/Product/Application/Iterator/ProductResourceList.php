<?php

declare(strict_types=1);

namespace App\Product\Application\Iterator;


use App\Product\Application\Resource\ProductResource;

class ProductResourceList
{
    private array $products = array();
    private int $productCount = 0;

    public function getProductCount()
    {
        return $this->productCount;
    }

    private function setProductCount($newCount)
    {
        $this->productCount = $newCount;
    }

    public function getProduct($productNumberToGet)
    {
        if ((is_numeric($productNumberToGet)) &&
            ($productNumberToGet <= $this->getProductCount())) {
            return $this->products[$productNumberToGet];
        } else {
            return NULL;
        }
    }

    public function addProduct(ProductResource $productResource)
    {
        $this->setProductCount($this->getProductCount() + 1);
        $this->products[$this->getProductCount()] = $productResource;
        return $this->getProductCount();
    }

    public function removeProduct(ProductResource $productResource)
    {
        $counter = 0;
        while (++$counter <= $this->getProductCount()) {
            if ($productResource->getId() ==
                $this->products[$counter]->getId()) {
                for ($x = $counter; $x < $this->getProductCount(); $x++) {
                    $this->products[$x] = $this->products[$x + 1];
                }
                $this->setProductCount($this->getProductCount() - 1);
            }
        }
        return $this->getProductCount();
    }
}