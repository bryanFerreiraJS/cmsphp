<?php

namespace Entity;


use Model\CommentManager;
use Model\ImageManager;
use Model\UserManager;

class Post extends BaseEntity
{
    private $id;
    private $date;
    private $title;
    private $content;
    private $authorId;
    private $imageId;

    public function getId()
    {
        return $this->id;
    }

    public function getDate(): \DateTime
    {
        return new \DateTime($this->date);
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getAuthor(): User
    {
        $manager = new UserManager();
        return $manager->getUserById($this->authorId);
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function setDate($date): void
    {
        $this->date = $date;
    }

    public function setTitle($title): void
    {
        $this->title = $title;
    }

    public function setContent($content): void
    {
        $this->content = $content;
    }

    public function getAuthorId()
    {
        return $this->authorId;
    }

    public function setAuthorId($authorId): void
    {
        $this->authorId = $authorId;
    }

    public function getComments(): array
    {
        $manager = new CommentManager();
        return $manager->getCommentsByPostId($this->id);
    }

    public function getImageId()
    {
        return $this->imageId;
    }

    public function setImageId($imageId): void
    {
        $this->imageId = $imageId;
    }


    public function hasImage(): bool
    {
        return $this->imageId !== null;
    }

    public function getImageUrl()
    {
        $manager = new ImageManager();
        $image = $manager->getImageById($this->imageId);
        return $image ? $image->buildUrl() : null;
    }
}