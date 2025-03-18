<?php

namespace App\Controller;

use App\DTO\CreateUserDTO;
use App\Entity\User;
use App\Service\AuthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class AuthController extends AbstractController
{
    #[Route('/auth/register', name: 'app_auth_register', methods: ['POST'])]
    public function register(
        #[MapRequestPayload]
        CreateUserDTO $payload,
        AuthService $authService,
    ): JsonResponse
    {
        $user = $authService->registerUser($payload);
        return $this->json(
            $user,
            Response::HTTP_CREATED,
            [],
            ['groups' => User::USERINFO],
        );
    }

    #[Route("/login", name: "app_login")]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('@EasyAdmin/page/login.html.twig', [
            // parameters usually defined in Symfony login forms
            'error' => $error,
            'last_username' => $lastUsername,
            'translation_domain' => 'admin',
            'page_title' => 'Login',
            // the label displayed for the Sign In form button (the |trans filter is applied to it)
            'sign_in_label' => 'Log in',
            // whether to enable or not the "remember me" checkbox (default: false)
            'remember_me_enabled' => true,
            // remember me name form field (default: '_remember_me')
            'remember_me_parameter' => 'custom_remember_me_param',
            // whether to check by default the "remember me" checkbox (default: false)
            'remember_me_checked' => true,
            // the label displayed for the remember me checkbox (the |trans filter is applied to it)
            'remember_me_label' => 'Remember me',
        ]);
    }
}