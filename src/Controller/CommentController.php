<?php


namespace Controller;


use Entity\Comment;
use Model\CommentManager;
use Model\PostManager;
use Model\UserManager;

class CommentController extends Controller
{
    public function executePostComment(): void
    {
        if (SecurityController::isAuthenticated() && isset($_POST['content'])) {
            $comment = new Comment(array(
                'postId' => $_POST['postId'],
                'authorId' => SecurityController::getLoggedUser()->getId(),
                'content' => $_POST['content']
            ));
            $controller = new CommentManager();
            $controller->addComment($comment);
        }

        $this->HTTPResponse->redirect('/article/' . $_POST['postId']);
    }

    public function executeDeleteComment(): void
    {
        $commentManager = new CommentManager();
        $comment = $commentManager->getCommentById($this->params['id']);
        $postId = $comment->getPostId();

        if (SecurityController::isAuthenticated() && SecurityController::getLoggedUser()->haveCommentRights($comment)) {
            $commentManager->deleteCommentById($this->params['id']);
        }

        $this->HTTPResponse->redirect('/article/' . $postId);
    }
}