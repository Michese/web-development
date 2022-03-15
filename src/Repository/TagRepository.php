<?php

namespace App\Repository;

use App\Entity\Tag;
use PDO;

class TagRepository extends BaseRepository
{

    public function getAllTags(): array
    {
        $sql = "SELECT tag.id, tag.title FROM tag";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
