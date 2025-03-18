<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GithubAuthController extends AbstractController 
{
    #[Route('/auth/github', name: 'github_autorize', methods: ['GET'])]
    public function authorize(
        HttpClientInterface $httpClient,
        #[MapQueryParameter("code")] ?string $authorizationCode, 
    ): Response
    {
        if (!$authorizationCode) {
            $query= http_build_query( [
                'client_id' => $this->getParameter('github.client_id'),
                'redirect_uri' => $this->getParameter('github.redirect_uri'),
            ]);
            $authorizeUrl = $urlGenerator->generate('https://github.com/login/oauth/authorize?'.$query);
            return $this->redirect($authorizeUrl);
        }
    }
}