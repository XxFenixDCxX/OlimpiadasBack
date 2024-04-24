<?php

namespace App\Controller;

use App\Service\AuthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends AbstractController
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function authenticate(Request $request): Response
    {
        $authHeader = $request->headers->get('Authorization');
        $token = str_replace('Bearer ', '', $authHeader);

        if (!$token) {
            return new Response('No token provided', Response::HTTP_UNAUTHORIZED);
        }

        $isValid = $this->authService->validateToken($token);
        
        if (!$isValid) {
            return new Response('Invalid token', Response::HTTP_UNAUTHORIZED);
        }

        return new Response('Authenticated successfully', Response::HTTP_OK);
    }
}