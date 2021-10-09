<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\PostRating;
use App\Repository\PostRepository;
use App\Service\ApiTokenService;
use App\Service\CookieService;
use App\Service\FileManagerService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use PHPUnit\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class HomeController extends AbstractController
{
    #[Route('/', name: 'home'),
    Route('/{route}', name: 'vue_pages',  requirements: ['route' => '^(?!.*api).+'])]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/api/createPost', name: 'create_post', methods: ['POST'])]
    public function createPost(Request $request, ValidatorInterface $validator, PostRepository $postRepository): Response
    {
        $cookie = new CookieService();

        if (!$cookie->checkApiToken($request)) {
            $cookie->clearCookie('apiToken');
            return new JsonResponse([ "success" => false, "exception" => 'Неверный токен']);
        }

        $content = json_decode($request->getContent(), true);

        try {
            $post = $postRepository->parseToPost($content);

            $errors = $validator->validate($post);
            if (count($errors) > 0) {
                return new Response((string) $errors, 400);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();
        } catch (Exception $exception) {
            return new JsonResponse(['exception' => $exception, 'success' => false]);
        }

        return new JsonResponse(["success" => true]);
    }

    #[Route('/api/colors', name: 'colors_route', methods: ['GET'])]
    public function colorsAction()
    {
//        $repository = $this->getDoctrine()->getRepository(Product::class);
// искать один Продукт по его основному ключу (обычно "id")
//        $product = $repository->find($id);
// искать один Продукт по имени
//        $product = $repository->findOneBy(['name' => 'Keyboard']);
// или по имени и цене
//        $product = $repository->findOneBy([
//            'name' => 'Keyboard',
//            'price' => 1999,
//        ]);
// искать несколько объектов Продуктов соответствующих имени, упорядоченные по цене
//        $products = $repository->findBy(
//            ['name' => 'Keyboard'],
//            ['price' => 'ASC']
//        );
// искать *все* объекты Продуктов
//        $products = $repository->findAll();




//        Удаление
//        $entityManager->remove($product);
//        $entityManager->flush();




//        $entityManager = $this->getEntityManager();
//
//        $query = $entityManager->createQuery(
//            'SELECT p
//            FROM App\Entity\Product p
//            WHERE p.price > :price
//            ORDER BY p.price ASC'
//        )->setParameter('price', $price);



//        $product = $productRepository
//            ->find($id);

        $fileManagerService = new FileManagerService();
        $image = $fileManagerService->getImage('615f51b8d39ea.jpg');
        return new JsonResponse(array('image' => $image, "success" => true));
    }

    #[Route('/api/getPosts', name: 'get_posts', methods: ['GET'])]
    public function getPosts(Request $request): Response
    {
        try {
            $page = intval($request->get('page'));
            $limit = intval($request->get('limit'));

            $result = $this->getDoctrine()->getManager()->getRepository(Post::class)->getPosts($page, $limit);
            $totalCount = $this->getDoctrine()->getManager()->getRepository(Post::class)->getTotalCount();

            $fileManagerService = new FileManagerService();
            foreach ($result as $key => $value) {
                $result[$key]['image'] = $fileManagerService->getImage($value['image']);
            }
        } catch(Exception $exception) {
            return new JsonResponse(['exception' => $exception, "success" => false]);
        }

        return new JsonResponse(['posts' => $result, "success" => true, "totalCount" => $totalCount]);
    }

    #[Route('/api/getPost', name: 'get_post', methods: ['GET'])]
    public function getPost(Request $request): Response
    {
        try {
            $postId = intval($request->get('post'));

            $result = $this->getDoctrine()->getManager()->getRepository(Post::class)->getPost($postId);

            $fileManagerService = new FileManagerService();
            $result['image'] = $fileManagerService->getImage($result['image']);

            $user = $request->getSession()->get('user');
            if ($user != null) {
                $result['myRating'] = $this->getDoctrine()->getManager()->getRepository(PostRating::class)->getUserRating($postId, $user['id']);
            } else {
                $result['myRating'] = null;
            }
        } catch(Exception $exception) {
            return new JsonResponse(['exception' => $exception, "success" => false]);
        }

        return new JsonResponse(['detailedPost' => $result, "success" => true]);
    }

    #[Route('/api/addRating', name: 'add_rating', methods: ['POST'])]
    public function addRating(Request $request): Response
    {
        $cookie = new CookieService();

        if (!$cookie->checkApiToken($request)) {
            $cookie->clearCookie('apiToken');
            return new JsonResponse([ "success" => false, "exception" => 'Неверный токен']);
        }

        $content = json_decode($request->getContent(), true);

        try {
            $postId = intval($content['post']);
            $rating = intval($content['rating']);
            $userId = $request->getSession()->get('user')['id'];

            $this->getDoctrine()->getManager()->getRepository(PostRating::class)->addRating($postId, $userId, $rating);
            $result =  $this->getDoctrine()->getManager()->getRepository(PostRating::class)->getRating($postId);

        } catch(Exception $exception) {
            return new JsonResponse(['exception' => $exception, "success" => false]);
        }

        return new JsonResponse(['rating' => $result['rating'], 'countVoted' => $result['countVoted'], 'myRating' => $rating, "success" => true]);
    }

    #[Route('/api/getMyRating', name: 'get_my_rating', methods: ['GET'])]
    public function getMyRating(Request $request): Response
    {
        $cookie = new CookieService();

        if (!$cookie->checkApiToken($request)) {
            $cookie->clearCookie('apiToken');
            return new JsonResponse([ "success" => false, "exception" => 'Неверный токен']);
        }

        try {
            $postId = intval($request->get('post'));

            $user = $request->getSession()->get('user');
            if ($user != null) {
                $rating = $this->getDoctrine()->getManager()->getRepository(PostRating::class)->getUserRating($postId, $user['id']);
            } else {
                $rating = null;
            }
        } catch(Exception $exception) {
            return new JsonResponse(['exception' => $exception, "success" => false]);
        }

        return new JsonResponse(['myRating' => $rating, "success" => true]);
    }
}
