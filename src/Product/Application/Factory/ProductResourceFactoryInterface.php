<?php

declare(strict_types=1);

namespace App\Product\Application\Factory;


use App\Product\Application\Resource\ProductResourceInterface;
use Symfony\Component\HttpFoundation\Request;

interface ProductResourceFactoryInterface
{
    public function createProductResourceFromRequest(Request $request): ProductResourceInterface;

//    abstract function createActivateProductResourceFromRequest(Request $request): ActivateProductResource;
}