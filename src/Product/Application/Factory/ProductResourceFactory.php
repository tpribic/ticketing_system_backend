<?php

declare(strict_types=1);

namespace App\Product\Application\Factory;


use App\Product\Application\Resource\ActivateProductResource;
use App\Product\Application\Resource\ProductResource;
use App\Product\Application\Resource\ProductResourceInterface;
use Symfony\Component\HttpFoundation\Request;

class ProductResourceFactory implements ProductResourceFactoryInterface
{
    public function createProductResourceFromRequest(Request $request): ProductResourceInterface
    {
        switch (true) {
            case $request->get('name'):
                $productResource = new ProductResource();
                $productResource
                    ->setName($request->get('name'))
                    ->setIsActive(false)
                    ->setProductType($request->get('type'))
                    ->setActivationNumber($request->get('activationKey'))
                    ->setSerialNumber($request->get('serialNumber'));
                return $productResource;
            case !$request->get('name'):
                $activateProductResource = new ActivateProductResource();
                $activateProductResource
                    ->setActivationNumber($request->get('activationKey'))
                    ->setSerialNumber($request->get('serialNumber'));
                return $activateProductResource;
        }
    }
}