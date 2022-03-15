<?php

namespace App\Repository;

use App\Entity\Role;
use PDO;

class RoleRepository extends BaseRepository
{
    public function find(int $roleId): Role
    {
        $sql = "SELECT * FROM role WHERE role.id = :role_id";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':role_id', $roleId);
        $stmt->execute();
        return $this->arrayToRole($stmt->fetch(PDO::FETCH_ASSOC));
    }

    private function arrayToRole(array $content): Role
    {
        $role = new Role();
        $role->setTitle($content['title']);
        $role->setId($content['id']);
        return $role;
    }

}
