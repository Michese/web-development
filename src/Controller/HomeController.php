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

    #[Route('/api/colors', name: 'colors_route', methods: ['GET'])]
    public function colorsAction()
    {
//        $repository = $this->getDoctrine()->getRepository(Product::class);
// искать один Продукт по его основному ключу (обычно "id")
//        $product = $repository->find($id);
// искать один Продукт по имени
//        $product = $repository->findOneBy(['name' => 'Keyboard']);
// или по имени и цене
//        $product = $repository->findOneBy([
//            'name' => 'Keyboard',
//            'price' => 1999,
//        ]);
// искать несколько объектов Продуктов соответствующих имени, упорядоченные по цене
//        $products = $repository->findBy(
//            ['name' => 'Keyboard'],
//            ['price' => 'ASC']
//        );
// искать *все* объекты Продуктов
//        $products = $repository->findAll();




//        Удаление
//        $entityManager->remove($product);
//        $entityManager->flush();




//        $entityManager = $this->getEntityManager();

//        $query = $entityManager->createQuery(
//            'SELECT p
//            FROM App\Entity\Product p
//            WHERE p.price > :price
//            ORDER BY p.price ASC'
//        )->setParameter('price', $price);



//        $product = $productRepository
//            ->find($id);
        return new JsonResponse(array('colors' => ['red', 'green','blue', 'yellow'], "success" => true));
    }
}
