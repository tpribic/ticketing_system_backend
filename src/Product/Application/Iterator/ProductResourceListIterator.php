<?php

declare(strict_types=1);

namespace App\Product\Application\Iterator;


use App\Common\IteratorInterface;

class ProductResourceListIterator implements IteratorInterface
{
    protected ProductResourceList $productList;
    protected int $currentProduct = 0;

    public function __construct(ProductResourceList $productResourceList)
    {
        $this->productList = $productResourceList;
    }

    public function getCurrent()
    {
        if (($this->currentProduct > 0) &&
            ($this->productList->getProductCount() >= $this->currentProduct)) {
            return $this->productList->getProduct($this->currentProduct);
        }
    }

    public function getNext()
    {
        if ($this->hasNext()) {
            return $this->productList->getProduct(++$this->currentProduct);
        } else {
            return NULL;
        }
    }

    public function hasNext()
    {
        if ($this->productList->getProductCount() > $this->currentProduct) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}