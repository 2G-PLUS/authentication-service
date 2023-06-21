<?php

namespace App\Controller;

use App\Manager\UserManager;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


class SecurityController extends AbstractController
{
    private UserManager $userManager;
    private UserPasswordHasherInterface $passwordEncoder;
    private JWTTokenManagerInterface $JWTManager;

    public function __construct(
        UserManager $userManager,
        UserPasswordHasherInterface $passwordEncoder,
        JWTTokenManagerInterface $JWTManager
    ) {
        $this->userManager = $userManager;
        $this->passwordEncoder = $passwordEncoder;
        $this->JWTManager = $JWTManager;
    }

    /**
     * @Route("/api/login", name="api_login", methods={"POST"})
     */
    public function login(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $username = $data['username'];
        $password = $data['password'];

        $user = $this->userManager->findUserByUsername($username);

        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], 404);
        }

        if (!$this->passwordEncoder->isPasswordValid($user, $password)) {
            return new JsonResponse(['error' => 'Invalid credentials'], 400);
        }

        $token = $this->JWTManager->create($user);

        return new JsonResponse(['token' => $token]);
    }
}
