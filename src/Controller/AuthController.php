<?php

namespace App\Controller;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends AbstractController
{
    private $jwtManager;

    public function __construct(JWTTokenManagerInterface $jwtManager)
    {
        $this->jwtManager = $jwtManager;
    }

    public function authenticate(Request $request, EntityManagerInterface $entityManager): Response
    {
        $authHeader = $request->headers->get('Authorization');
        $token = str_replace('Bearer ', '', $authHeader);

        if (!$token) {
            return new Response('No token provided', Response::HTTP_UNAUTHORIZED);
        }

        $tokenParts = explode('.', $token);
        
        if (count($tokenParts) != 3) {
            return new Response('Invalid token', Response::HTTP_UNAUTHORIZED);
        }

        $payload = base64_decode($tokenParts[1]);

        $payloadData = json_decode($payload, true);

        if (!isset($payloadData['sub'])) {
            return new Response('Invalid token', Response::HTTP_UNAUTHORIZED);
        }
        
        $sub = $payloadData['sub'];

        $userRepository = $entityManager->getRepository(Users::class);
        $user = $userRepository->findOneBy(['sub' => $sub]);

        if(!$user) {
            return new Response('Invalid token', Response::HTTP_UNAUTHORIZED);
        }

        return new Response('Authenticated successfully', Response::HTTP_OK);
    }
}