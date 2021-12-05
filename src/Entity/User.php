<?php


namespace Entity;


use Model\CommentManager;
use Model\PostManager;

class User extends BaseEntity
{
    private $id;
    private $firstName;
    private $lastName;
    private $email;
    private $password;
    private $roles;

    public function getId()
    {
        return $this->id;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function checkRoles(): array
    {
        $roles = unserialize($this->roles);
        $roles[] .= 'ROLE_USER';
        return $roles;
    }

    public function isAdmin(): bool
    {
        return in_array('ROLE_ADMIN', $this->checkRoles());
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function setFirstName($firstName): void
    {
        $this->firstName = $firstName;
    }

    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }

    public function setEmail($email): void
    {
        $this->email = $email;
    }

    public function setPassword($password): void
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function setRoles($roles): void
    {
        $this->roles = serialize($roles);
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function getPosts(): array
    {
        $manager = new PostManager();
        return $manager->getPostsByAuthorId($this->id);
    }

    public function getComments(): array
    {
        $manager = new CommentManager();
        return $manager->getCommentsByAuthorId($this->id);
    }

    public function setAdmin($admin): bool
    {
        if ($admin) {
            $roles = unserialize($this->roles);
            $roles[] .= 'ROLE_ADMIN';
            $this->setRoles($roles);
            return true;
        }

        $this->setRoles([]);
        return false;
    }

    public function havePostRights(Post $post): bool
    {
        return $post->getAuthorId() === $this->id || $this->isAdmin();
    }

    public function haveCommentRights(Comment $comment): bool
    {
        return $comment->getAuthorId() === $this->id || $this->isAdmin();
    }
}