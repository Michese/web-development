<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Uid\Uuid;

class UserController extends AbstractController
{
    /**
     * @param Request $request
     * @return Response
     * @IsGranted("ROLE_ADMIN")
     */
    #[Route('/api/user', name: 'get_user')]
    public function index(Request $request): Response
    {
//        $user = $request->getSession()->get('user');
//        dd( $this->getUser());
        return new JsonResponse([
            'user' => $this->getUser(),
        ]);
    }

    /**
     * @param User|null $user
     * @return Response
     */
    #[Route('/api/login', name: 'api_login')]
    public function login(#[CurrentUser] ?User $user): Response
    {
        if (null === $user) {
            return $this->json([
                'message' => 'missing credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = Uuid::v1();

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
            'user' => $user->getUserIdentifier(),
            'token' => $token,
        ]);
    }
}
