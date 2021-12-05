<?php

namespace Model;

use Entity\User;

class UserManager extends DbConnexion
{

    public function getUserById(int $id)
    {
        $query = $this->db->prepare('SELECT * FROM users WHERE id = :id');
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Entity\User');
        return $query->fetch();
    }

    public function getUserByEmail(string $email = null)
    {
        $query = $this->db->prepare('SELECT * FROM users WHERE email = :email');
        $query->bindValue(':email', $email, \PDO::PARAM_STR);
        $query->execute();
        $query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, 'Entity\User');
        return $query->fetch();
    }

    public function userExists(string $email): bool
    {
        return $this->getUserByEmail($email) instanceof User;
    }
    
    public function addUser(User $newUser): User
    {
        $insert = $this->db->prepare('INSERT INTO users (firstName, lastName, email, password) VALUES (:firstName, :lastName, :email, :password)');
        $insert->bindValue(':firstName', $newUser->getFirstName(), \PDO::PARAM_STR);
        $insert->bindValue(':lastName', $newUser->getLastName(), \PDO::PARAM_STR);
        $insert->bindValue(':email', $newUser->getEmail(), \PDO::PARAM_STR);
        $insert->bindValue(':password', $newUser->getPassword(), \PDO::PARAM_STR);
        $insert->execute();

        return $this->getUserByEmail($newUser->getEmail());
    }

    public function userMatches(User $user): bool
    {
        return $this->getUserByEmail($user->getEmail())->getPassword() === $user->getPassword();
    }

    public function checkCredentials($login = null, $password = null)
    {
        if ( !is_string($login) || !is_string($password)) {
            return false;
        }

        $user = $this->getUserByEmail($login);

        if ($user !== false && password_verify($password, $user->getPassword())) {
            return $user;
        }
        return false;
    }

    public function getAllUsers(): array
    {
        $query = $this->db->query('SELECT * FROM users');
        $query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, 'Entity\User');
        return $query->fetchAll();
    }

    public function updateUser(User $user): User
    {
        $update = $this->db->prepare('UPDATE users SET firstName = :firstName, lastName = :lastName, password = :password, roles = :roles WHERE email = :email');
        $update->bindValue(':firstName', htmlspecialchars($user->getFirstName()), \PDO::PARAM_STR);
        $update->bindValue(':lastName', htmlspecialchars($user->getLastName()), \PDO::PARAM_STR);
        $update->bindValue(':email', htmlspecialchars($user->getEmail()), \PDO::PARAM_STR);
        $update->bindValue(':password', htmlspecialchars($user->getPassword()), \PDO::PARAM_STR);
        $update->bindValue(':roles', $user->getRoles(), \PDO::PARAM_STR);
        $update->execute();

        return $this->getUserByEmail($user->getEmail());
    }

    public function deleteUserByEmail(string $email): bool
    {
        $delete = $this->db->prepare('DELETE FROM users WHERE email = :email');
        $delete->bindValue(':email', $email, \PDO::PARAM_STR);

        $commentManager = new CommentManager();
        $commentManager->deleteCommentsByAuthorId($this->getUserByEmail($email)->getId());

        $postManager = new PostManager();
        $postManager->deletePostsByAuthorId($this->getUserByEmail($email)->getId());

        return $delete->execute();
    }

    public function deleteUserById(int $id): bool
    {
        $delete = $this->db->prepare('DELETE FROM users WHERE id = :id');
        $delete->bindValue(':id', $id, \PDO::PARAM_INT);

        $commentManager = new CommentManager();
        $commentManager->deleteCommentsByAuthorId($id);

        $postManager = new PostManager();
        $postManager->deletePostsByAuthorId($id);

        return $delete->execute();
    }

}