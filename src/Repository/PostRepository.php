<?php

namespace App\Repository;

use App\Entity\Post;
use App\Entity\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

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

        if (array_key_exists('description', $content)) $post->setDescription($content['description']);
        if (array_key_exists('author', $content)) $post->setAuthor($content['author']);

        return $post;
    }

    /**
     * @return Post[]
     */
    public function getPosts(int $page, int $limit, string $search = "", int $user_id = -1): array
    {
        $entityManager = $this->getEntityManager();
        $cb = $entityManager->createQueryBuilder();
        $query = $cb
            ->select(['p.id', 'p.title', 'p.author', 'p.description', 'p.image', 't.title as tag', 'p.created_at', 'avg(pr.rating) as rating'])
            ->from('App\Entity\Post', 'p')
            ->innerJoin('p.tag', 't')
            ->leftJoin('p.postRatings', 'pr')
            ->where(
                $cb->expr()->like('p.title', ':search')
            )
            ->andWhere('p.user_id=:user_id or -1 = :user_id')
            ->groupBy('p.id')
            ->orderBy('p.created_at', 'DESC')
            ->setMaxResults($limit)
            ->setFirstResult($limit * ( $page - 1 ))
            ->setParameter('search', "%$search%")
            ->setParameter('user_id', $user_id)
            ->getQuery();
        return $query->getResult();
    }

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getPost(int $postId): array
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQueryBuilder()
            ->select(['p.id', 'p.title', 'p.author', 'p.description', 'p.image', 'u.name', 'count(pr.rating) as countVoted',  'avg(pr.rating) as rating'])
            ->from('App\Entity\Post', 'p')
            ->innerJoin('App\Entity\User', 'u', 'WITH', 'u.id = p.user_id')
            ->leftJoin('p.postRatings', 'pr')
            ->where('p.id=:postId')
            ->groupBy('p.id')
            ->orderBy('p.created_at', 'DESC')
            ->setParameter('postId', $postId)
            ->getQuery();
        return $query->getOneOrNullResult();
    }

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getTotalCount(string $search = "", int $user_id = -1): int
    {
        $entityManager = $this->getEntityManager();
        $cb = $entityManager->createQueryBuilder();
        $query = $cb
            ->select('count(p) as count')
            ->from('App\Entity\Post', 'p')
            ->where(
                $cb->expr()->like('p.title', ':search')
            )
            ->andWhere('p.user_id=:user_id or -1 = :user_id')
            ->setParameter('search', "%$search%")
            ->setParameter('user_id', $user_id)
            ->getQuery()
            ->getOneOrNullResult();
        return $query['count'];
    }
}
