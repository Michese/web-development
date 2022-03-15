<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use App\Repository\PostRatingRepository;
use App\Repository\PostRepository;
use App\Repository\TagRepository;
use App\Repository\UserRepository;
use App\Service\CookieService;
use App\Service\FileManagerService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


class HomeController extends BaseController
{
    /**
     * @throws Exception
     */
    public function index(): Response
    {
        return $this->renderTemplate('index.php');
    }

    public function createPost(): Response
    {
        $cookie = new CookieService();

        if (!$cookie->checkApiToken($this->request)) {
            $cookie->clearCookie('apiToken');
            return new JsonResponse(["success" => false, "exception" => 'Неверный токен']);
        }

        $content = json_decode($this->request->getContent(), true);

        try {
            $postRepository = new PostRepository();
            $post = $postRepository->parseToPost($content);
            $tagId = $content['tag_id'];
            $postId = $postRepository->createPost($post, $tagId);

        } catch (Exception $exception) {
            return new JsonResponse(['exception' => $exception, 'success' => false]);
        }

        return new JsonResponse(["success" => true, "postId" => $postId]);
    }

    public function getPosts(): JsonResponse
    {
        try {
            $page = intval($this->request->get('page'));
            $limit = intval($this->request->get('limit'));
            $isProfile = boolval($this->request->get('isProfile'));
            $search = $this->request->get('search');
            $user_id = -1;

            if ($isProfile) {
                $user = $this->request->getSession()->get('user');
                $user_id = $user['id'];
            }

            $postRepository = new PostRepository();
            $result = $postRepository->getPosts($page, $limit, $search, $user_id);
            $totalCount = $postRepository->getTotalCount($search, $user_id);
            $fileManagerService = new FileManagerService();
            foreach ($result as $key => $value) {
                $result[$key]['image'] = $fileManagerService->getImage($value['image']);
            }
        } catch (Exception $exception) {
            return new JsonResponse(['exception' => $exception, "success" => false]);
        }

        return new JsonResponse(['posts' => $result, "success" => true, "totalCount" => $totalCount]);
    }

    public function getPost(): Response
    {
        try {
            $postId = intval($this->request->get('post'));

            $result = (new PostRepository())->getPost($postId);

            $fileManagerService = new FileManagerService();
            $result['image'] = $fileManagerService->getImage($result['image']);

            $user = $this->request->getSession()->get('user');
            if ($user != null) {
                $result['myRating'] = (new PostRatingRepository())->getUserRating($postId, $user['id']);
            } else {
                $result['myRating'] = null;
            }
        } catch (Exception $exception) {
            return new JsonResponse(['exception' => $exception, "success" => false]);
        }

        return new JsonResponse(['detailedPost' => $result, "success" => true]);
    }

    public function addRating(): Response
    {
        $cookie = new CookieService();

        if (!$cookie->checkApiToken($this->request)) {
            $cookie->clearCookie('apiToken');
            return new JsonResponse(["success" => false, "exception" => 'Неверный токен']);
        }

        $content = json_decode($this->request->getContent(), true);

        try {
            $postId = intval($content['post']);
            $rating = intval($content['rating']);
            if ($rating > 5 || $rating < 1) {
                throw new \Exception('Рейтинг имеет неверный формат!');
            }
            $userId = $this->request->getSession()->get('user')['id'];

            $postRatingRepository = new PostRatingRepository();
            $postRatingRepository->addRating($postId, $userId, $rating);
            $result = $postRatingRepository->getRating($postId);

        } catch (Exception $exception) {
            return new JsonResponse(['exception' => $exception, "success" => false]);
        }

        return new JsonResponse(['rating' => $result['rating'], 'countVoted' => $result['countVoted'], 'myRating' => $rating, "success" => true]);
    }

    public function getMyRating(): Response
    {
        $cookie = new CookieService();

        if (!$cookie->checkApiToken($this->request)) {
            $cookie->clearCookie('apiToken');
            return new JsonResponse(["success" => false, "exception" => 'Неверный токен']);
        }

        try {
            $postId = intval($this->request->get('post'));

            $user = $this->request->getSession()->get('user');
            if ($user != null) {
                $rating = (new PostRatingRepository())->getUserRating($postId, $user['id']);
            } else {
                $rating = null;
            }
        } catch (Exception $exception) {
            return new JsonResponse(['exception' => $exception, "success" => false]);
        }

        return new JsonResponse(['myRating' => $rating, "success" => true]);
    }

    public function getComments(): JsonResponse
    {
        $commentRepository = new CommentRepository();
        try {
            $postId = intval($this->request->get('post'));
            $comments = $commentRepository->getCommentsByPostId($postId);
        } catch (Exception $exception) {
            return new JsonResponse(['exception' => $exception, "success" => false]);
        }

        return new JsonResponse(['comments' => $comments, "success" => true]);
    }

    public function createComment(): Response
    {
        $cookie = new CookieService();

        if (!$cookie->checkApiToken($this->request)) {
            $cookie->clearCookie('apiToken');
            return new JsonResponse(["success" => false, "exception" => 'Неверный токен']);
        }

        $content = json_decode($this->request->getContent(), true);

        try {
            $commentRepository = new CommentRepository();

            $comment = $commentRepository->parseToComment($content);

            $postId = intval($content['post_id']); // TODO PostRepository find
            $userId = $this->request->getSession()->get('user')['id'];

            $commentRepository->createComment($comment, $postId, $userId);
            $comments = $commentRepository->getCommentsByPostId($postId);
        } catch (Exception $exception) {
            return new JsonResponse(['exception' => $exception, 'success' => false]);
        }

        return new JsonResponse(['comments' => $comments, "success" => true]);
    }

    public function getTags(): Response
    {
        try {
            $tags = (new TagRepository())->getAllTags();
        } catch (Exception $exception) {
            return new JsonResponse(['exception' => $exception, "success" => false]);
        }

        return new JsonResponse(['tags' => $tags, "success" => true]);
    }
}
