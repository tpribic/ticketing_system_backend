<?php

declare(strict_types=1);

namespace App\Product\Application\Controller;


use App\Common\ObjectTransformerInterface;
use App\Common\Service\TokenDecoderService;
use App\Product\Application\Factory\ProductResourceFactoryInterface;
use App\Product\Domain\Manager\ProductManager;
use App\Product\Domain\Model\Product;
use App\User\Infrastructure\Doctrine\Main\Entity\UserEntity;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductCrudController extends AbstractController
{

    private ProductManager $productManager;
    private TokenDecoderService $tokenService;
    private ProductResourceFactoryInterface $resourceFactory;
    private ObjectTransformerInterface $objectTransformer;

    /**
     * ProductCrudController constructor.
     * @param ProductManager $productManager
     * @param TokenDecoderService $tokenService
     */
    public function __construct(ProductManager $productManager, TokenDecoderService $tokenService, ProductResourceFactoryInterface $resourceFactory)
    {
        $this->productManager = $productManager;
        $this->tokenService = $tokenService;
        $this->resourceFactory = $resourceFactory;
    }

    public function registerProduct(Request $request): Response
    {
        $product = $this->productFactory->createUserFromRequest($request);

        $this->productManager->save($product);

        return new Response(null, Response::HTTP_ACCEPTED);
    }

    public function getUserProducts(Request $request): Response
    {
        //dohvatiti produkte za usera (potencijalno preko jwt tokena i emaila
        $request->get('userId');
    }

}