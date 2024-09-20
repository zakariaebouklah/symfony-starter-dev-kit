<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LibertyController extends AbstractController
{
    #[Route('/liberty', name: 'app_liberty')]
    public function index(): Response
    {
        return $this->render('liberty/index.html.twig', [
            'controller_name' => 'LibertyController',
        ]);
    }
}
