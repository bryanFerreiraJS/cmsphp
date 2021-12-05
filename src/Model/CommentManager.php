<?php


namespace Model;


use Entity\Comment;

class CommentManager extends DbConnexion
{

    public function getCommentsByAuthorId(int $authorId): array
    {
        $query = $this->db->prepare('SELECT * FROM comments WHERE authorId = :authorId');
        $query->bindValue(':authorId', $authorId, PDO::PARAM_INT);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Entity\Comment');

        return $query->fetchAll();
    }

    public function addComment(Comment $comment, bool $getArray = false)
    {
        $insert = $this->db->prepare('INSERT INTO comments (postId, authorId, content) VALUES (:postId, :authorId, :content)');
        $insert->bindValue(':postId', $comment->getPostId(), \PDO::PARAM_INT);
        $insert->bindValue(':authorId', $comment->getAuthorId(), \PDO::PARAM_INT);
        $insert->bindValue(':content', nl2br(htmlspecialchars($comment->getContent())), \PDO::PARAM_STR);

        return $insert->execute() ? $this->getCommentById($this->db->lastInsertId(), $getArray) : false;
    }

    public function getCommentById(int $id, bool $array = false)
    {
        $query = $this->db->prepare('SELECT * FROM comments WHERE id = :id');
        $query->bindValue(':id', $id, \PDO::PARAM_INT);
        $query->execute();

        if ($array) {
            return $query->fetchAll(\PDO::FETCH_ASSOC);
        }

        $query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, 'Entity\Comment');
        return $query->fetch();
    }
    
    public function deleteCommentById(int $id): bool
    {
        $delete = $this->db->prepare('DELETE FROM comments WHERE id = :id');
        $delete->bindValue(':id', $id, \PDO::PARAM_INT);

        return $delete->execute();
    }

    public function commentExists(int $id): bool
    {
        return (bool)$this->getCommentById($id);
    }

    public function getAllComments(bool $array = false): array
    {
        $query = $this->db->query('SELECT * FROM comments');

        if ($array) {
            return $query->fetchAll(\PDO::FETCH_ASSOC);
        }

        $query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, 'Entity\Comment');
        return $query->fetchAll();
    }
}
