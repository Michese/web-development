<?php

namespace App\Repository;

use App\Entity\Post;
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
        $post->setTitle($content['title']);
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
    public function getPosts(int $page, int $limit): array
    {
        $entityManager = $this->getEntityManager();

//        $query = $entityManager->createQuery(
//            'SELECT post.id, post.author, post.description, post.image, post.created_at FROM App\Entity\Post post
//            JOIN App\Entity\PostRating post_rating WHERE post_rating.post = post.id'
//        )
//            ->setMaxResults($limit)
//            ->setFirstResult($limit * ( $page - 1 ));
        $query = $entityManager->createQueryBuilder()
            ->select(['p.id', 'p.author', 'p.description', 'p.image', 'p.created_at', 'avg(pr.rating) as rating'])
            ->from('App\Entity\Post', 'p')
            ->leftJoin('p.postRatings', 'pr')
            ->groupBy('p.id')
            ->orderBy('p.created_at', 'DESC')
            ->setMaxResults($limit)
            ->setFirstResult($limit * ( $page - 1 ))
            ->getQuery();
        return $query->getResult();
    }

    // /**
    //  * @return Post[] Returns an array of Post objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Post
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
