<?php

namespace App\Repository;

use App\Entity\NewItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @method NewItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method NewItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method NewItem[]    findAll()
 * @method NewItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NewItem::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(NewItem $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(NewItem $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function getAllNews(): array
    {
        $entityManager = $this->getEntityManager();
        $cb = $entityManager->createQueryBuilder();
        $query = $cb
            ->select(['item.id', 'item.title', 'item.description', 'item.createdAt'])
            ->from('App\Entity\NewItem', 'item')
            ->where('item.deletedAt IS NULL')
//            ->andWhere('p.user_id=:user_id or -1 = :user_id')
            ->orderBy('item.createdAt', 'DESC')
//            ->setMaxResults($limit)
//            ->setFirstResult($limit * ( $page - 1 ))
//            ->setParameter('search', "%$search%")
//            ->setParameter('user_id', $user_id)
            ->getQuery();
        return $query->getResult();
    }

    public function findNew(int $id): array
    {
        $entityManager = $this->getEntityManager();
        $cb = $entityManager->createQueryBuilder();
        $query = $cb
            ->select(['item.title', 'item.description', 'item.text', 'item.createdAt', 'item.views'])
            ->from('App\Entity\NewItem', 'item')
            ->where('item.id = :new_id')
            ->andWhere('item.deletedAt IS NULL')
            ->setParameter('new_id', $id)
//            ->setParameter('user_id', $user_id)
            ->getQuery();
        return $query->getResult();
    }

    #[ArrayShape(['id' => "int|null", 'title' => "null|string", 'description' => "null|string", 'text' => "null|string", 'createdAt' => "\DateTimeImmutable|null", 'views' => "null|string", 'admin_name' => "null|string", 'adminId' => "int|null"])]
    public function toArray(NewItem $new): array
    {
        $newArray = [
            'id' => $new->getId(),
            'title' => $new->getTitle(),
            'description' => $new->getDescription(),
            'text' => $new->getText(),
            'createdAt' => $new->getCreatedAt(),
            'views' => $new->getViews(),
        ];
        if ($new->getAdminId()) {
            $newArray['adminId'] = $new->getAdminId()->getId();
            $newArray['adminName'] = $new->getAdminId()->getFirstName() . ' ' . $new->getAdminId()->getLastName();
        }

        return $newArray;
    }

    // /**
    //  * @return NewItem[] Returns an array of NewItem objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NewItem
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
