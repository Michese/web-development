<?php

namespace App\Entity;

class PostRating
{
    private $id;
    private $user;
    private $post;
    private $rating;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->user;
    }

    public function setUserId(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPostId(): ?Post
    {
        return $this->post;
    }

    public function setPostId(?Post $post_id): self
    {
        $this->post = $post_id;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }
}
