<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use App\Service\ApiTokenService;
use App\Service\CookieService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends BaseController
{
//    #[Route('/api/login', name: 'app_login', methods: ['POST'])]
    public function login(): Response
    {
        $cookie = new CookieService();
        $session = new Session();
        $session->clear();
        try {
            $content = json_decode($this->request->getContent(), true);
            $userRepository = new UserRepository();
            $user = $userRepository->getUserByEmail(mb_strtolower($content['email']));
            if ($user->checkPassword($content['password'])) {
                $apiToken = (new ApiTokenService())->create();
                $user->setLastLoginDate(new \DateTimeImmutable('now'));

//                $entityManager = $this->getDoctrine()->getManager();
//                $entityManager->persist($user);
//                $entityManager->flush();
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
                throw new \Exception('Неверный логин или пароль!');
            }
        } catch (Exception $exception) {
            return new JsonResponse(['exception' => $exception->getMessage(), 'success' => false]);
        }
    }

//    #[Route('/api/register', name: 'app_register', methods: ['POST'])]
    public function register(): Response
    {
        $content = json_decode($this->request->getContent(), true);
        try {
            $userRepository = new UserRepository();
            $user = $userRepository->parseToUser($content);
            $role = (new RoleRepository())->find(1); // TODO find
            $user->setLastLoginDate((new \DateTimeImmutable('now')))
                ->setRole($role);
            $user->setPassword(password_hash($user->getPassword(), true));

//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->persist($user);
//            $entityManager->flush();

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

//    #[Route('/api/logout', name: 'app_logout', methods: ['POST'])]
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

//    #[Route('/api/getUser', name: 'app_get_user', methods: ['GET'])]
    public function getCurrentUser(): Response
    {
//        $this->request;
        $cookie = new CookieService();

        if (!$cookie->checkApiToken($this->request)) {
            return new JsonResponse(["success" => false, "exception" => 'Неверный токен']);
        }
        $userArray = $this->request->getSession()->get('user');
        return new JsonResponse(["success" => true, "user" => $userArray]);
    }
}
