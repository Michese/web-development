<?php

namespace App\Repository;

use App\Entity\PostRating;
use PDO;

class PostRatingRepository extends BaseRepository
{
    public function addRating(int $postId, int $userId, int $rating): void
    {
        $sql = "INSERT INTO post_rating (post_id, user_id, rating) VALUES (:post_id, :user_id, :rating)";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':post_id', $postId, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getRating(int $postId): array | null
    {
        $sql = "SELECT avg(pr.rating) as rating, count(pr.rating) as countVoted FROM post_rating pr
WHERE pr.post_id=:post_id
GROUP BY pr.post_id";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':post_id', $postId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserRating(int $postId, int $userId): int | null
    {
        $sql = "SELECT pr.rating as myRating FROM post_rating pr
WHERE pr.post_id=:post_id AND pr.user_id=:user_id";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':post_id', $postId, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $query =  $stmt->fetch(PDO::FETCH_ASSOC);

        if ($query != null) {
            $result = $query['myRating'];
        } else {
            $result = null;
        }
        return $result;
    }
}
