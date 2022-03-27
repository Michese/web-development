<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\NewItem;
use App\Repository\CommentRepository;
use App\Repository\NewItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home'),
        Route('/{route}', name: 'vue_pages', requirements: ['route' => '^(?!.*api).+'])]
    public function index(): Response
    {
        return $this->render('base.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/api/getNews', name: 'get_news', methods: ['GET']) ]
    public function getPosts(NewItemRepository $newRepository): Response
    {
        $news = $newRepository->getAllNews();
        return new JsonResponse(['news' => $news]);
    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     */
    #[Route('/api/getNew/{id}', name: 'get_new', methods: ['GET']) ]
    public function getPost(int $id, NewItemRepository $newRepository, CommentRepository $commentRepository): Response
    {
        $new = $newRepository->find($id);

        // TODO условие инкремента

        $new->setViews($new->getViews() + 1);
        $newRepository->add($new);
        $newArray = $newRepository->toArray($new);
        $comments = $commentRepository->getAllComments($id);
        return new JsonResponse(['newItem' => $newArray, 'comments' => $comments]);
    }
}
