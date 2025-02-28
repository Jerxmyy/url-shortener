<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ShortUrlController extends AbstractController
{
    #[Route('/short/url', name: 'app_short_url')]
    public function index(): Response
    {
        return $this->render('short_url/index.html.twig', [
            'controller_name' => 'ShortUrlController',
        ]);
    }
}
