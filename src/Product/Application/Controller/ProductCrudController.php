<?php

declare(strict_types=1);

namespace App\Product\Application\Controller;


use App\Common\Service\TokenDecoderService;
use App\Product\Application\Factory\ProductResourceFactoryInterface;
use App\Product\Application\Iterator\ProductResourceListIterator;
use App\Product\Application\Iterator\ProductResourceList;
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
     * @param SerializerInterface $serializer
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
            $created = $this->productManager->save($model);
        } catch (\DomainException $exception) {
            return new Response ($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
        $resource = $this->objectTransformer->fromDomain($created);
        $response = json_encode($this->serializer->serialize($resource, 'json'));
        return new Response (json_decode($response), Response::HTTP_CREATED);
    }

    public function getAllProducts(Request $request): JsonResponse
    {
        $products = $this->productManager->getAllProducts();

        $response = $this->createProductsResponse($products);

        return new JsonResponse($response);
    }

    public function getAllRegisteredProducts(Request $request): JsonResponse
    {
        $products = $this->productManager->getAllRegisteredProducts();

        $response = $this->createProductsResponse($products);

        return new JsonResponse($response);
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
     * @param array $response
     * @return array
     */
    private function createProductsResponse($products, array $response = []): array
    {
        $productResourceList = new ProductResourceList();
        foreach ($products as $product) {
            $productResourceList->addProduct($this->objectTransformer->fromDomain($product));
        }

        $iterator = new ProductResourceListIterator($productResourceList);

        while ($iterator->hasNext()) {
            $iterator->getNext();
            $response[] = json_decode($this->serializer->serialize($iterator->getCurrent(), 'json', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['user' => 'password', 'salt', 'roles']]));
        }
        return $response;
    }

}