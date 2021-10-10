<?php

namespace App\Repository;

use App\Entity\PostRating;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PostRating|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostRating|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostRating[]    findAll()
 * @method PostRating[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRatingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostRating::class);
    }

    public function addRating(int $postId, int $userId, int $rating): void
    {
        $entityManager = $this->getEntityManager();
        $rsm = new ResultSetMappingBuilder($entityManager);
        $entityManager->createNativeQuery("INSERT INTO post_rating (post_id, user_id, rating) VALUES (:post_id, :user_id, :rating)", $rsm)
            ->setParameters(['post_id' => $postId, 'user_id' => $userId, 'rating' => $rating])
            ->getResult();
    }

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getRating(int $postId): array | null
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQueryBuilder()
            ->select(['avg(pr.rating) as rating', 'count(pr.rating) as countVoted'])
            ->from('App\Entity\PostRating', 'pr')
            ->where('pr.post=:post_id')
            ->groupBy('pr.post')
            ->setParameter('post_id', $postId)
            ->getQuery();
        return $query->getOneOrNullResult();
    }

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getUserRating(int $postId, int $userId): int | null
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQueryBuilder()
            ->select('pr.rating as myRating')
            ->from('App\Entity\PostRating', 'pr')
            ->where('pr.post=:post_id')
            ->andWhere('pr.user=:user_id')
            ->setParameters(['post_id' => $postId, 'user_id' => $userId])
            ->getQuery()
            ->getOneOrNullResult();
        if ($query != null) {
            $result = $query['myRating'];
        } else {
            $result = null;
        }
        return $result;
    }
}
