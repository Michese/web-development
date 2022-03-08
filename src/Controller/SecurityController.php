<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use App\Service\ApiTokenService;
use App\Service\CookieService;
use Cassandra\Timestamp;
use PHPUnit\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SecurityController extends AbstractController
{
    #[Route('/api/login', name: 'app_login', methods: ['POST'])]
    public function login(Request $request, UserRepository $userRepository): Response
    {
        $cookie = new CookieService();
        $session = new Session();
        try {
            $content = json_decode($request->getContent(), true);
            $user = $userRepository->getUserByEmail(mb_strtolower($content['email']));

            if ($user->checkPassword($content['password'])) {
                $apiToken = (new ApiTokenService())->create();
                $user->setLastLoginDate(new \DateTimeImmutable ('now'));
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                $currentUser = $userRepository->parseToArray($user);
                $session->start();
                $session->set('user', $currentUser);
                $session->set('apiToken', $apiToken);

                $cookie->sendCookie('apiToken', $apiToken);

                return new JsonResponse([
                    "success" => true,
                    'user' => $currentUser,
                ]);
            } else {
                $session->clear();
                $cookie->clearCookie('apiToken');
                throw new \PHPUnit\Util\Exception('Неверный логин или пароль!');
            }
        } catch (Exception $exception) {
            return new JsonResponse(['exception' => $exception->getMessage(), 'success' => false]);
        }
    }

    #[Route('/api/register', name: 'app_register', methods: ['POST'])]
    public function register(Request $request, ValidatorInterface $validator, UserRepository $userRepository, RoleRepository $roleRepository): Response
    {
        $content = json_decode($request->getContent(), true);
        try {

            $user = $userRepository->parseToUser($content);
            $role = $roleRepository->find(1);
            $user->setLastLoginDate((new \DateTimeImmutable ('now')))
                ->setRole($role);

            $errors = $validator->validate($user);
            if (count($errors) > 0) {
                return new Response((string)$errors, 400);
            }

            $user->setPassword(password_hash($user->getPassword(), true));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $apiToken = (new ApiTokenService())->create();
            $currentUser = $userRepository->parseToArray($user);

            $session = new Session();
            $session->start();
            $session->set('apiToken', $apiToken);
            $session->set('user', $currentUser);

            $cookie = new CookieService();
            $cookie->sendCookie('apiToken', $apiToken);

        } catch (Exception $exception) {
            return new JsonResponse(['exception' => 'Невалидные данные', 'success' => false]);
        }

        return new JsonResponse([
            'user' => $currentUser,
            'success' => true,
        ]);
    }

    #[Route('/api/logout', name: 'app_logout', methods: ['POST'])]
    public function logout(): Response
    {
        try {
            $session = new Session();
            $session->clear();
            $cookie = new CookieService();
            $cookie->clearCookie('apiToken');
        } catch (Exception $exception) {
            return new JsonResponse(['exception' => $exception, 'success' => false]);
        }

        return new JsonResponse(["success" => true]);
    }

    #[Route('/api/getUser', name: 'app_get_user', methods: ['GET'])]
    public function getCurrentUser(Request $request): Response
    {

        $cookie = new CookieService();

        if (!$cookie->checkApiToken($request)) {
            return new JsonResponse(["success" => false, "exception" => 'Неверный токен']);
        }
//        $entityManager = $this->getDoctrine()->getManager();
//        $user = $entityManager->getRepository(User::class)->find($request->getSession()->get('user')['id'])->get();
//        $user->setLastLoginDate(time());
//        $entityManager->flush();
        return new JsonResponse(["success" => true, "user" => $request->getSession()->get('user')]);
    }
}
