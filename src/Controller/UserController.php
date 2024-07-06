<?php

namespace App\Controller;

use App\Message\UserMessage;
use App\Entity\EvcUser;
use App\MessageHandler\UserMessageHandler;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Messenger\MessageBusInterface;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

#[Route('/rest/user', name: 'app_user')]
class UserController extends AbstractController
{
    public function __construct(
        protected MessageBusInterface $messageBus, 
        protected LoggerInterface $logger,
        protected EntityManagerInterface $entityManager,
		protected CacheInterface $cache
    ) {
    }

    #[Route('/get/{userEmail}', name: 'user_get', methods: ['GET'])]
    public function get($userEmail): JsonResponse
    {
        $userMessage = new UserMessage(function: 'getUser', userEmail: $userEmail, url: "{$_ENV['SYMFONY_URL']}user/get/{$userEmail}?apikey={$_ENV['API_KEY']}");

        $handler = new UserMessageHandler($this->logger, $this->entityManager,$this->cache);
        $user = $handler($userMessage);
		return $this->json($user);

        $this->logger->info('User not found for ID: ' . $userEmail);

        return $this->json(['error' => 'User not found'], 404);
    }
}
