<?php

namespace App\Repository;

use App\Entity\Comment;
use PDO;

class CommentRepository extends BaseRepository
{
    public function getCommentsByPostId(int $postId): array
    {
        $sql = "SELECT `comment`.*, `user`.name as userName, `user`.id as userId FROM `comment` INNER JOIN `user` on `user`.id = `comment`.user_id WHERE `comment`.post_id = :post_id AND `comment`.deleted_at IS NULL ORDER BY created_at DESC";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':post_id', $postId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

//        $entityManager = $this->getEntityManager();
//        $rsm = new ResultSetMappingBuilder($entityManager);
//        $rsm->addRootEntityFromClassMetadata('App\Entity\Comment', 'comment');
//        $rsm->addJoinedEntityFromClassMetadata('App\Entity\User', 'user', 'comment', 'user', array(
//            'id' => 'user_id',
//        ));
//        return $entityManager->createNativeQuery(
//            'SELECT `comment`.*, `user`.name FROM `comment` INNER JOIN `user` on `user`.id = `comment`.user_id WHERE `comment`.post_id = :post_id AND `comment`.deleted_at IS NULL ORDER BY created_at DESC', $rsm)
//            ->setParameters(['post_id' => $postId])
//            ->getArrayResult();
    }

    public function parseToComment(array $content): Comment
    {
        $comment = new Comment();
        $comment->setText($content['text']);
        $comment->setCreatedAt((new \DateTimeImmutable('now')));
        return $comment;
    }

    public function createComment(Comment $comment, int $postId, int $userId): void
    {
        $sql = "INSERT INTO comment (post_id, user_id, text) VALUES (:post_id, :user_id, :text)";
        $text = $comment->getText();
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':post_id', $postId, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':text', $text);
        $stmt->execute();
    }
}
