<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    public function login(): Response
    {
        $user = $this->getUser();

        if (null == $user) {
            return $this->json([
                'message' => 'missing credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = Uuid::v1();

        return $this->json([
            'user' =>  $this->getUser()->toArray(),
            'token' => $token,
        ]);
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
     * @IsGranted("ROLE_USER", message="Авторизируйтесь!")
     */
    #[Route('/api/logout', name: 'api_logout', methods: ['GET'])]
    public function logout(#[CurrentUser] ?User $user): Response
    {
        return $this->json([
            'success' => true,
        ]);
    }
}
