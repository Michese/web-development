<?php

namespace App\Controller;

use App\Entity\User;
use PHPUnit\Util\Json;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/api/login", name="app_login")
     */
    public function login(): Response
    {
//        AuthenticationUtils $authenticationUtils
         if ($this->getUser()) {
             return new JsonResponse(array('exception' => 'Вы уже вошли!', "success" => true));
         }

        // get the login error if there is one
//        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
//        $lastUsername = $authenticationUtils->getLastUsername();

//        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
        return new JsonResponse(array('user' => [
            $this->getUser()
        ], "success" => true));
    }

    #[Route('/api/register', name: 'app_register', methods: ['POST'])]
    public function register(Request $request): Response
    {
        $content = json_decode($request->getContent(), true);
        return new JsonResponse($content);
        $entityManager = $this->getDoctrine()->getManager();
        $user = new User();

        $user->setName('Keyboard');
        $user->setPrice(1999);
        $user->setDescription('Ergonomic and stylish!');
        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($user);
        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
        return new Response('Saved new product with id '.$user->getId());
    }

    /**
     * @Route("/api/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
