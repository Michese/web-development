<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    #[Route('/', name: 'home'),
    Route('/{route}', name: 'vue_pages',  requirements: ['route' => '^(?!.*api).+'])]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/api/colors', name: 'colors_route')]
    public function colorsAction()
    {
        return new JsonResponse(array('colors' => ['red', 'green','blue', 'yellow'], "success" => true));
    }
}
