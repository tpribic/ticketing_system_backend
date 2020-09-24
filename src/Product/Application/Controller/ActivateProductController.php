<?php


namespace App\Product\Application\Controller;


use App\Common\Service\TokenDecoderService;
use App\Product\Application\Factory\ProductResourceFactoryInterface;
use App\Product\Application\ObjectTransformer\ActivateProductResourceObjectTransformer;
use App\Product\Domain\Manager\ProductManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ActivateProductController extends AbstractController
{
    private ProductManager $productManager;
    private TokenDecoderService $tokenService;
    private ProductResourceFactoryInterface $resourceFactory;
    private ActivateProductResourceObjectTransformer $objectTransformer;

    /**
     * ProductCrudController constructor.
     * @param ProductManager $productManager
     * @param TokenDecoderService $tokenService
     */
    public function __construct(ProductManager $productManager, TokenDecoderService $tokenService, ProductResourceFactoryInterface $resourceFactory, ActivateProductResourceObjectTransformer $objectTransformer)
    {
        $this->productManager = $productManager;
        $this->tokenService = $tokenService;
        $this->resourceFactory = $resourceFactory;
        $this->objectTransformer = $objectTransformer;
    }

    public function activateProduct(Request $request): Response
    {
        $tokenData = $this->tokenService->decodeToken($request);
        $resource = $this->resourceFactory->createProductResourceFromRequest($request);
        $model = $this->objectTransformer->toDomain($resource);

        try {
            $this->productManager->activateProduct($model, $tokenData['username']);
        } catch (\DomainException $exception) {
            return new Response ($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        return new Response (null, Response::HTTP_OK);
    }
}