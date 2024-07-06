<?php

namespace App\Controller;

use App\Entity\EvcProduct;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Messenger\MessageBusInterface;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Component\HttpFoundation\Request;

#[Route('/rest/product', name: 'app_product')]
class ProductController extends AbstractController
{
    
	public function __construct(
        /*protected MessageBusInterface $messageBus, 
        protected LoggerInterface $logger,
        protected EntityManagerInterface $entityManager,
		protected CacheInterface $cache*/
    ) {
    }
	
	#[Route('/list', name: 'product_list', methods: ['GET'])]
    public function list(): JsonResponse
    {
       /* $prodMessage = new ProductMessage(function: 'prodList', url: "{$_ENV['SYMFONY_URL']}product/list?apikey={$_ENV['API_KEY']}", limit: 1000);

        $handler = new ProductMessageHandler($this->logger, $this->entityManager,$this->cache);
        $prodList = $handler($prodMessage);
		return $this->json($prodList);

        $this->logger->info('no products found');

        return $this->json(['error' => 'no products found'], 404);*/
    }

	#[Route('/get/{prodId}', name: 'get_product', methods: ['GET'])]
    public function get(int $prodId): JsonResponse
    {
        /*$prodMessage = new ProductMessage(function: 'getProd', url: "{$_ENV['SYMFONY_URL']}product/get/{$prodId}?apikey={$_ENV['API_KEY']}", prodId: $prodId, limit: 1000);

        $handler = new ProductMessageHandler($this->logger, $this->entityManager,$this->cache);
        $prod = $handler($prodMessage);
		$data = json_decode($prod, true);
		return new JsonResponse($data);

        $this->logger->info('no product found');

        return $this->json(['error' => 'no product found'], 404);*/
    }

	#[Route('/change', name: 'change_product', methods: ['PUT'])]
	public function change(Request $request): JsonResponse
    {
        /*$json = json_decode($request->getContent(), true);
		$prodMessage = new ProductMessage(function: 'setProd', url: "{$_ENV['SYMFONY_URL']}product/get/{$json['data']['prod_id']}?apikey={$_ENV['API_KEY']}",data: $json['data'], where: $json['where']);

        $handler = new ProductMessageHandler($this->logger, $this->entityManager,$this->cache);
        $prod = $handler($prodMessage);
		$data = json_decode($prod, true);
		return new JsonResponse($data);

        $this->logger->info('no product found');

        return $this->json(['error' => 'no product found'], 404);*/
    }
}
