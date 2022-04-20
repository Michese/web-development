<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\NewItem;
use App\Repository\CommentRepository;
use App\Repository\NewItemRepository;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class HomeController extends AbstractController
{
    private Serializer $serializer;

    public function __construct()
    {
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $this->serializer = new Serializer([ new DateTimeNormalizer(), $normalizer]);
    }

    #[Route('/', name: 'home'),
        Route('/{route}', name: 'vue_pages', requirements: ['route' => '^(?!.*(api|admin)).+'])]
    public function index(): Response
    {
        return $this->render('base.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/api/new', name: 'get_news', methods: ['GET']) ]
    public function getPosts(NewItemRepository $newRepository): Response
    {
        $news = $newRepository->findAll();
        $jsonNewItem = $this->serializer->normalize($news, null, ['groups' => ['half']]);
        return new JsonResponse(['news' => $jsonNewItem]);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    #[Route('/api/new/{id}', name: 'get_new', methods: ['GET']) ]
    public function getPost(int $id, NewItemRepository $newRepository): Response
    {
        $new = $newRepository->find($id);

        if ($this->isGranted('ROLE_ADMIN')) {
            $comments = $new->getComments();
        } else {
            $comments = $new->getComments()->filter(function(Comment $comment) {
                return $comment->getAdmin() != null;
            });
        }

        if ($this->getUser() && $new->getAdmin()->getId() != $this->getUser()->getId()) {
            $new->setViews($new->getViews() + 1);
            $newRepository->add($new);
        }

        $jsonNewItem = $this->serializer->normalize($new, null, ['groups' => ['new']]);
        $jsonComments = $this->serializer->normalize($comments, null, ['groups' => ['new']]);
        return new JsonResponse(['newItem' => $jsonNewItem, 'comments' => $jsonComments]);
    }

    /**
     * @param Request $request
     * @param NewItemRepository $newItemRepository
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     * @IsGranted("ROLE_ADMIN", message="У вас недостаточно прав!")
     */
    #[Route('/api/new', name: 'create_new', methods: ['POST']) ]
    public function createNew(Request $request, NewItemRepository $newItemRepository): Response
    {
        $user = $this->getUser();

        if ($user == null) return new JsonResponse([ 'result' => false ]);

        $parameters = json_decode($request->getContent(), true);
        $newItem = $newItemRepository->createNew($user, $parameters);
        $newItemRepository->add($newItem);

        return new JsonResponse([
            'result' => $newItem->getId(),
        ]);
    }

    /**
     * @param int $newId
     * @param Request $request
     * @param NewItemRepository $newItemRepository
     * @param CommentRepository $commentRepository
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     * @IsGranted("ROLE_USER", message="Необходимо зарегистрироваться!")
     */
    #[Route('/api/new/{newId}/comment', name: 'create_new', methods: ['POST']) ]
    public function createComment(int $newId, Request $request, NewItemRepository $newItemRepository, CommentRepository $commentRepository): Response
    {
        $user = $this->getUser();

        if ($user == null) return new JsonResponse([ 'result' => false ]);
        $new = $newItemRepository->find($newId);

        $parameters = json_decode($request->getContent(), true);
        $comment = $commentRepository->createComment($user, $new, $parameters);
        $commentRepository->add($comment);

        return new JsonResponse([
            'result' => $comment->getId(),
        ]);
    }

    /**
     * @param int $newId
     * @param int $commentId
     * @param NewItemRepository $newItemRepository
     * @param CommentRepository $commentRepository
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     * @IsGranted("ROLE_ADMIN", message="У вас недостаточно прав!")
     */
    #[Route('/api/new/{newId}/comment/{commentId}', name: 'approve_comment', methods: ['PATCH'])]
    public function approveComment(int $newId, int $commentId, NewItemRepository $newItemRepository, CommentRepository $commentRepository): Response
    {
        $comment = $commentRepository->find($commentId);
        $user = $this->getUser();
        $comment->setAdmin($user);
        $commentRepository->add($comment);

        return new JsonResponse(['result' => true]);
    }
}
