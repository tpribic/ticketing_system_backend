<?php

declare(strict_types=1);

namespace App\Product\Application\Controller;


use App\Common\Service\TokenDecoderService;
use App\Product\Application\Factory\ProductResourceFactoryInterface;
use App\Product\Application\ObjectTransformer\ProductResourceObjectTransformer;
use App\Product\Domain\Manager\ProductManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class ProductCrudController extends AbstractController
{

    private ProductManager $productManager;
    private TokenDecoderService $tokenService;
    private ProductResourceFactoryInterface $resourceFactory;
    private ProductResourceObjectTransformer $objectTransformer;
    private SerializerInterface $serializer;

    /**
     * ProductCrudController constructor.
     * @param ProductManager $productManager
     * @param TokenDecoderService $tokenService
     * @param ProductResourceFactoryInterface $resourceFactory
     * @param ProductResourceObjectTransformer $objectTransformer
     * @param Serializer $serializer
     */
    public function __construct(
        ProductManager $productManager,
        TokenDecoderService $tokenService,
        ProductResourceFactoryInterface $resourceFactory,
        ProductResourceObjectTransformer $objectTransformer,
        SerializerInterface $serializer
    )
    {
        $this->productManager = $productManager;
        $this->tokenService = $tokenService;
        $this->resourceFactory = $resourceFactory;
        $this->objectTransformer = $objectTransformer;
        $this->serializer = $serializer;
    }

    public function create(Request $request): Response
    {
        $resource = $this->resourceFactory->createProductResourceFromRequest($request);
        $model = $this->objectTransformer->toDomain($resource);

        try {
            $this->productManager->save($model);
        } catch (\DomainException $exception) {
            return new Response ($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        return new Response (null, Response::HTTP_CREATED);
    }

    public function getLoggedUserProducts(Request $request): JsonResponse
    {
        $decodedToken = $this->tokenService->decodeToken($request);
        $products = $this->productManager->getUserProducts($decodedToken['username']);

        $response = $this->createProductsResponse($products);

        return new JsonResponse(['products' => $response]);
    }

    /**
     * @param $products
     * @param array $parsedProducts
     * @param array $response
     * @return array
     */
    public function createProductsResponse($products, array $parsedProducts = [], array $response = []): array
    {
        foreach ($products as $product) {
            $parsedProducts[] = $this->objectTransformer->fromDomain($product);
        }

        foreach ($parsedProducts as $parsed) {
            $response[] = json_decode($this->serializer->serialize($parsed, 'json', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['user' => 'password', 'name', 'surname', 'salt', 'roles']]));
        }
        return $response;
    }

}