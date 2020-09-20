<?php

declare(strict_types=1);

namespace App\Product\Application\Controller;


use App\Product\Domain\Manager\ProductManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductCrudController extends AbstractController
{

    private ProductManager $productManager;


    public function __construct(ProductManager $productManager)
    {
        $this->productManager = $productManager;
    }

    public function activateProduct(Request $request): Response
    {
    }

    //admin moze dodavati novi product
    public function registerProduct(Request $request): Response
    {
        $user = $this->userFactory->createUserFromRequest($request);

        $this->productManager->save($product);

        return new Response(null, Response::HTTP_ACCEPTED);
    }

//    public function getUserProducts(Request $request): Response

}