<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\NewItem;
use App\Repository\CommentRepository;
use App\Repository\NewItemRepository;
use App\Service\FileManagerService;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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

    /**
     * @param NewItem $newItem
     * @param NewItemRepository $newRepository
     * @return JsonResponse
     * @throws ExceptionInterface
     */
    #[Route('/api/new_items/{id}', name: 'get_new', methods: ['GET']) ]
    public function getPost(NewItem $newItem, NewItemRepository $newRepository): JsonResponse
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            $comments = $newItem->getComments()->filter(function(Comment $comment) {
                return $comment->getDeletedAt() == null;
            });
        } else {
            $comments = $newItem->getComments()->filter(function(Comment $comment) {
                return $comment->getIsActive() && $comment->getDeletedAt() == null;
            });
        }

        if ($this->getUser() && $newItem->getAdmin()->getId() != $this->getUser()->getId()) {
            $newItem->setViews($newItem->getViews() + 1);
            $newRepository->add($newItem);
        }

        $jsonNewItem = $this->serializer->normalize($newItem, null, ['groups' => ['new']]);
        $jsonComments = $this->serializer->normalize($comments, null, ['groups' => ['new']]);
        return new JsonResponse(['newItem' => $jsonNewItem, 'comments' => $jsonComments]);
    }

    /**
     * @param Request $request
     * @param NewItemRepository $newItemRepository
     * @param ValidatorInterface $validator
     * @return JsonResponse
     * @IsGranted("ROLE_ADMIN", message="У вас недостаточно прав!")
     */
    #[Route('/api/new_items', name: 'create_new', methods: ['POST']) ]
    public function createNew(Request $request, NewItemRepository $newItemRepository, ValidatorInterface $validator): JsonResponse
    {
        $user = $this->getUser();

        $parameters = json_decode($request->getContent(), true);
        $newItem = $newItemRepository->createNew($user, $parameters);

        $errors = $validator->validate($newItem);

        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            return new JsonResponse($errorsString);
        }

        $newItemRepository->add($newItem);

        return new JsonResponse([
            'result' => $newItem->getId(),
        ]);
    }

    /**
     * @param int $newId
     * @param Request $request
     * @param NewItemRepository $newItemRepository
     * @param ValidatorInterface $validator
     * @param FileManagerService $fileManagerService
     * @return JsonResponse
     * @IsGranted("ROLE_ADMIN", message="У вас недостаточно прав!")
     */
    #[Route('/api/new_items/{newId}', name: 'edit_new', methods: ['PUT']) ]
    public function editNew(int $newId, Request $request, NewItemRepository $newItemRepository, ValidatorInterface $validator, FileManagerService $fileManagerService): JsonResponse
    {
        $user = $this->getUser();

        if ($user == null) return new JsonResponse([ 'result' => false ]);

        $parameters = json_decode($request->getContent(), true);
        $newItem = $newItemRepository->find($newId);
        if (array_key_exists('image', $parameters)) {
            $newItem->setImage($parameters['image']);
        }

        $newItem->setAdmin($user);
        $newItem->setTitle($parameters['title']);
        $newItem->setDescription($parameters['description']);
        $newItem->setText($parameters['text']);

        $errors = $validator->validate($newItem);

        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            return new JsonResponse($errorsString);
        }

        $newItemRepository->add($newItem);

        return new JsonResponse([
            'result' => $newItem->getId(),
        ]);
    }

    /**
     * @param NewItem $newItem
     * @param NewItemRepository $newItemRepository
     * @return JsonResponse
     * @IsGranted("ROLE_ADMIN", message="У вас недостаточно прав!")
     */
    #[Route('/api/new_items/{id}', name: 'delete_new') ]
    public function deleteNew(NewItem $newItem, NewItemRepository $newItemRepository): JsonResponse
    {
        $newItemRepository->remove($newItem);
        return new JsonResponse([
            'result' => true,
        ]);
    }

    /**
     * @param int $newId
     * @param Request $request
     * @param NewItemRepository $newItemRepository
     * @param CommentRepository $commentRepository
     * @param ValidatorInterface $validator
     * @return JsonResponse
     * @throws ORMException
     * @throws OptimisticLockException
     * @IsGranted("ROLE_USER", message="Необходимо зарегистрироваться!")
     */
    #[Route('/api/new_items/{newId}/comment', name: 'create_comment', methods: ['POST']) ]
    public function createComment(int $newId, Request $request, NewItemRepository $newItemRepository, CommentRepository $commentRepository, ValidatorInterface $validator): JsonResponse
    {
        $user = $this->getUser();

        if ($user == null) return new JsonResponse([ 'result' => false ]);
        $new = $newItemRepository->find($newId);

        $parameters = json_decode($request->getContent(), true);
        $comment = $commentRepository->createComment($user, $new, $parameters);

        $errors = $validator->validate($comment);

        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            return new JsonResponse($errorsString);
        }

        if ($this->isGranted('ROLE_ADMIN')) {
            $comment->setIsActive(true);
        }

        $commentRepository->add($comment);

        return new JsonResponse([
            'result' => $comment->getId(),
        ]);
    }

    /**
     * @param int $newId
     * @param int $commentId
     * @param CommentRepository $commentRepository
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     * @IsGranted("ROLE_ADMIN", message="У вас недостаточно прав!")
     */
    #[Route('/api/new_items/{newId}/comment/{commentId}', name: 'approve_comment', methods: ['PATCH'])]
    public function approveComment(int $newId, int $commentId, CommentRepository $commentRepository): Response
    {
        $comment = $commentRepository->find($commentId);
        $comment->setIsActive(true);
        $commentRepository->add($comment);

        return new JsonResponse(['result' => true]);
    }

    /**
     * @param int $newId
     * @param int $commentId
     * @param CommentRepository $commentRepository
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     * @IsGranted("ROLE_ADMIN", message="У вас недостаточно прав!")
     */
    #[Route('/api/new_items/{newId}/comment/{commentId}', name: 'delete_comment', methods: ['DELETE'])]
    public function deleteComment(int $newId, int $commentId, CommentRepository $commentRepository): Response
    {
        $comment = $commentRepository->find($commentId);
        $comment->setDeletedAt(new \DateTimeImmutable('now'));
        $commentRepository->add($comment);

        return new JsonResponse(['result' => true]);
    }

    /**
     * @param Request $request
     * @param FileManagerService $fileManagerService
     * @return JsonResponse
     * @IsGranted("ROLE_ADMIN", message="У вас недостаточно прав!")
     */
    #[Route('/api/file', name: 'upload_file', methods: ['POST'])]
    public function uploadFile(Request $request, FileManagerService $fileManagerService): JsonResponse
    {
        $newFile = $request->files->get('file');
        $fileName = $fileManagerService->upload($newFile);

        return new JsonResponse(['result' => $fileName]);
    }
}
