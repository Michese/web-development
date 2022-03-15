<?php

namespace App\Repository;

use App\Entity\User;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use PDO;


class UserRepository extends BaseRepository
{
    public function find(int $userId): User
    {
        $sql = "SELECT `user`.* FROM user WHERE user.id = :user_id";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        $userArray = $stmt->fetch(PDO::FETCH_ASSOC);
        $user = $this->parseToUser($userArray);

        $roleRepository = new RoleRepository();
        $role = $roleRepository->find($userArray['role_id']);
        $user->setRole($role);
        return $user;
    }

    public function getUserByEmail(string $email): User
    {
        $sql = "SELECT * FROM user WHERE user.email = :email";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $userArray = $stmt->fetch(PDO::FETCH_ASSOC);
        $user = $this->parseToUser($userArray);
        $roleRepository = new RoleRepository();
        $role = $roleRepository->find($userArray['role_id']);
        $user->setRole($role);
        return $user;
    }

    public function getUserByApiToken(string $apiToken): User
    {
        $sql = "SELECT * FROM user WHERE p.api_token = :api_token";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':api_token', $apiToken);
        $stmt->execute();
        return $stmt->fetchObject(PDO::FETCH_ASSOC);
//        return $this->createQuery(
//            'SELECT *
//            FROM user
//            WHERE p.api_token = :api_token'
//        )->setParameter('api_token', $apiToken);
    }

    #[Pure] #[ArrayShape(['id' => "int|null", 'email' => "null|string", 'name' => "null|string", 'phone' => "null|string", 'last_login_date' => "\DateTimeImmutable|null", 'role' => "null|string"])]
    public function parseToArray(User $user): array
    {
        return [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'name' => $user->getName(),
            'phone' => $user->getPhone(),
            'last_login_date' => $user->getLastLoginDate(),
            'role' => $user->getRole()->getTitle(),
        ];
    }

    public function parseToUser(array $content): User
    {
        $user = new User();
        $user->setName($content['name']);
        $user->setEmail($content['email']);
        $user->setPassword($content['password']);
        $user->setPhone($content['phone']);
        $user->setId($content['id']);
        return $user;
    }
}
