<?php

namespace App\Repository;

use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    public function getCommentsByPostId(int $postId): array {
        $entityManager = $this->getEntityManager();
        $rsm = new ResultSetMappingBuilder($entityManager);
        $rsm->addRootEntityFromClassMetadata('App\Entity\Comment', 'comment');
        $rsm->addJoinedEntityFromClassMetadata('App\Entity\User', 'user', 'comment', 'user', array(
            'id' => 'user_id',
        ));
        return $entityManager->createNativeQuery(
            'SELECT `comment`.*, `user`.name FROM `comment` INNER JOIN `user` on `user`.id = `comment`.user_id WHERE `comment`.post_id = :post_id AND `comment`.deleted_at IS NULL ORDER BY created_at DESC', $rsm)
            ->setParameters(['post_id' => $postId])
            ->getArrayResult();
//        return $entityManager->createQueryBuilder()
//            ->select('com.user_id, com.text, com.created_at')
//            ->from('App\Entity\Comment', 'com')
//            ->where('com.post=:post_id')
//            ->andWhere('com.deleted_at IS NULL')
//            ->setParameters(['post_id' => $postId])
//            ->getQuery()
//            ->getResult();
    }

    public function parseToComment(array $content): Comment
    {
        $comment = new Comment();
        $comment->setText($content['text']);
        $comment->setCreatedAt((new \DateTimeImmutable ('now')));
        return $comment;
    }

    // /**
    //  * @return Comment[] Returns an array of Comment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Comment
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
