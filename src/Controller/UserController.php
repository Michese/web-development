<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{
    /**
     * @return JsonResponse
     * @IsGranted("ROLE_USER")
     */
    #[Route('/api/user', name: 'get_user', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return new JsonResponse(["user" => $this->getUser()->toArray()]);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    #[Route('/api/register', name: 'api_register')]
    public function register(Request $request, UserPasswordHasherInterface $hasher, UserRepository $userRepository, ValidatorInterface $validator): JsonResponse
    {
        $parameters = json_decode($request->getContent(), true);

        $user = new User();
        $user->setFirstName($parameters['firstName'])
            ->setLastName($parameters['lastName'])
            ->setEmail($parameters['email'])
            ->setPhone($parameters['phone'])
            ->setRoles([])
            ->setLastDayVisit(new \DateTimeImmutable('now'));

        $password = $hasher->hashPassword($user, $parameters['password']);
        $user->setPassword($password);

        $errors = $validator->validate($user);

        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            return new JsonResponse($errorsString);
        }

        $userRepository->add($user);

        return new JsonResponse([
            'result' => true,
        ]);
    }

    /**
     * @param User|null $user
     * @return Response
     * @IsGranted("ROLE_USER", message="??????????????????????????????!")
     */
    #[Route('/api/logout', name: 'api_logout', methods: ['GET'])]
    public function logout(Request $request): Response
    {
        $response = new Response();
        $response->headers->clearCookie('PHPSESSID');
        $response->send();
        return $this->json([
            'success' => true,
        ]);
    }
}
