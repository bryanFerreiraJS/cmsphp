<?php


namespace Entity;


use Model\PostManager;
use Model\UserManager;

class Comment extends BaseEntity
{
    private $id;
    private $date;
    private $postId;
    private $authorId;
    private $content;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getDate(): \DateTime
    {
        return new \DateTime($this->date);
    }

    public function setDate($date): void
    {
        $this->date = $date;
    }

    public function getPostId()
    {
        return $this->postId;
    }

    public function setPostId($postId): void
    {
        $this->postId = $postId;
    }

    public function getAuthorId()
    {
        return $this->authorId;
    }

    public function setAuthorId($authorId): void
    {
        $this->authorId = $authorId;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content): void
    {
        $this->content = $content;
    }

    public function getAuthor(): User
    {
        $manager = new UserManager();
        return $manager->getUserById($this->authorId);
    }

    public function getPost(): Post
    {
        $manager = new PostManager();
        return $manager->getPostById($this->postId);
    }
}