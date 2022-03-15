<?php

namespace App\Repository;

use App\Entity\Post;
use PDO;

class PostRepository extends BaseRepository
{

    /**
     * @throws \Exception
     */
    public function parseToPost(array $content): Post
    {
        $post = new Post();
        if (!array_key_exists('title', $content)) {
            throw new \Exception("Название не найдено!");
        }
        $post->setTitle($content['title']);
        if (!array_key_exists('image', $content)) {
            throw new \Exception("Файл не найден!");
        }
        $imageLength = strlen($content['image']);
        if ($imageLength < 5) {
            throw new \Exception("Файл не найден!");
        }
        if ($imageLength > 3145728) {
            throw new \Exception("Файл слишком большой!");
        }
        $post->setImage($content['image']);
        $post->setUserId($content['user_id']);
        $post->setCreatedAt();

        if (array_key_exists('description', $content)) {
            $post->setDescription($content['description']);
        }
        if (array_key_exists('author', $content)) {
            $post->setAuthor($content['author']);
        }

        return $post;
    }

    public function getPosts(int $page, int $limit, string $search = "", int $user_id = -1): array
    {
        $sql = "SELECT p.id, p.title, p.author, p.description, p.image, t.title as tag, p.created_at as created_at, avg(pr.rating) as rating FROM post p
INNER JOIN tag t on p.tag_id = t.id
LEFT JOIN post_rating pr on pr.post_id = p.id
WHERE p.title LIKE :search AND (p.user_id=:user_id OR -1 = :user_id)
GROUP BY p.id
ORDER BY p.created_at DESC
LIMIT :limit
OFFSET :offset";

        $stmt = $this->dbh->prepare($sql);
        $searchParam = '%' . $search . '%';
        $offsetParam = $limit * ($page - 1);
        $stmt->bindParam(':search', $searchParam);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offsetParam, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getPost(int $postId): array
    {
        $sql = "SELECT p.id, p.title, p.author, p.description, p.image, u.name, count(pr.rating) as countVoted, avg(pr.rating) as rating FROM post p 
INNER JOIN user u on u.id = p.user_id
LEFT JOIN post_rating pr on pr.post_id = p.id
WHERE p.id = :post_id
GROUP BY p.id
ORDER BY p.created_at DESC";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':post_id', $postId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
//        $entityManager = $this->getEntityManager();
//        $query = $entityManager->createQueryBuilder()
//            ->select(['p.id', 'p.title', 'p.author', 'p.description', 'p.image', 'u.name', 'count(pr.rating) as countVoted',  'avg(pr.rating) as rating'])
//            ->from('App\Entity\Post', 'p')
//            ->innerJoin('App\Entity\User', 'u', 'WITH', 'u.id = p.user_id')
//            ->leftJoin('p.postRatings', 'pr')
//            ->where('p.id=:postId')
//            ->groupBy('p.id')
//            ->orderBy('p.created_at', 'DESC')
//            ->setParameter('postId', $postId)
//            ->getQuery();
//        return $query->getOneOrNullResult();
    }

    public function getTotalCount(string $search = "", int $user_id = -1): int
    {
        $sql = "SELECT count(p.id) as count FROM post p
WHERE p.title LIKE :search AND (p.user_id=:user_id OR -1 = :user_id)";
        $searchParam = '%' . $search . '%';
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':search', $searchParam);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['count'];
//        $entityManager = $this->getEntityManager();
//        $cb = $entityManager->createQueryBuilder();
//        $query = $cb
//            ->select('count(p) as count')
//            ->from('App\Entity\Post', 'p')
//            ->where(
//                $cb->expr()->like('p.title', ':search')
//            )
//            ->andWhere('p.user_id=:user_id or -1 = :user_id')
//            ->setParameter('search', "%$search%")
//            ->setParameter('user_id', $user_id)
//            ->getQuery()
//            ->getOneOrNullResult();
//        return $query['count'];
    }

    public function createPost(Post $post, int $tagId): int
    {
        $sql = "INSERT INTO post (tag_id, image, title, description, author, user_id) VALUES (:tag_id, :image, :title, :description, :author, :user_id)";
        $image = $post->getNameFileImage();
        $title = $post->getTitle();
        $description = $post->getDescription();
        $author = $post->getAuthor();
        $userId = $post->getUserId();
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':tag_id', $tagId, PDO::PARAM_INT);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $this->dbh->lastInsertId();
    }
}
