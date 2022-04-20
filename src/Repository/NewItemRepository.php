<?php

namespace App\Repository;

use App\Entity\NewItem;
use App\Entity\User;
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

    public function add(NewItem $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function remove(NewItem $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function createNew(User $user, array $params): NewItem
    {
        $newItem = new NewItem();
        return $newItem->setText($params['text'])
            ->setTitle($params['title'])
            ->setDescription($params['description'])
            ->setViews(0)
            ->setCreatedAt(new \DateTimeImmutable('now'))
            ->setAdmin($user);
    }

    #[ArrayShape(['id' => "int|null", 'title' => "null|string", 'description' => "null|string", 'text' => "null|string", 'createdAt' => "\DateTimeImmutable|null", 'views' => "null|string", 'admin_name' => "null|string", 'admin' => "int|null"])]
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
        if ($new->getAdmin()) {
            $newArray['admin'] = $new->getAdmin()->getId();
            $newArray['adminName'] = $new->getAdmin()->getFirstName() . ' ' . $new->getAdmin()->getLastName();
        }

        return $newArray;
    }
}
