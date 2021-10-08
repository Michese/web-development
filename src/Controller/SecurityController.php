<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Service\ApiTokenService;
use App\Service\CookieService;
use PHPUnit\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
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

                $currentUser = $userRepository->parseToArray($user);
                $session->start();
                $session->set('user', $currentUser);
                $session->set('apiToken', $apiToken);

                $cookie->sendCookie('apiToken', $apiToken);

                return new JsonResponse([
                    "success" => true,
                    'user' => $currentUser,
                ]);
            }
            else {
                $session->clear();
                $cookie->clearCookie('apiToken');
                throw new \PHPUnit\Util\Exception('Неверный логин или пароль!');
            }
        } catch (Exception $exception) {
            return new JsonResponse(['exception' => $exception->getMessage(), 'success' => false]);
        }
    }

    #[Route('/api/register', name: 'app_register', methods: ['POST'])]
    public function register(Request $request, ValidatorInterface $validator, UserRepository $userRepository): Response
    {
        $content = json_decode($request->getContent(), true);
        try {
            $user = $userRepository->parseToUser($content);

            $errors = $validator->validate($user);
            if (count($errors) > 0) {
                return new Response((string) $errors, 400);
            }

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
            return new JsonResponse(['exception' => $exception, 'success' => false]);
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
            return new JsonResponse([ 'exception' => $exception, 'success' => false ]);
        }

        return new JsonResponse([ "success" => true ]);
    }

    #[Route('/api/getUser', name: 'app_get_user', methods: ['GET'])]
    public function getCurrentUser(Request $request): Response
    {

        $cookie = new CookieService();

        if (!$cookie->checkApiToken($request)) {
            return new JsonResponse([ "success" => false, "exception" => 'Неверный токен']);
        }

        $user = $request->getSession()->get('user');
        return new JsonResponse([ "success" => true, "user" => $user]);
    }
}
