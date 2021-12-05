<?php


namespace Controller;


use Entity\Comment;
use Entity\Post;
use Model\CommentManager;
use Model\PostManager;
use Model\UserManager;

class AdminController extends Controller
{
    public function executeIndex()
    {
        if (SecurityController::isAuthenticated()) {
            return $this->render('Zone Admin', [], 'Admin/index');
        }

        $this->HTTPResponse->redirect('/login');
    }

    public function executeUserlist()
    {
        if (SecurityController::isAuthenticated() && SecurityController::getLoggedUser()->isAdmin()) {
            $userManager = new UserManager();
            return $this->render('User list', [
                'users' => $userManager->getAllUsers()
            ], 'Admin/userlist');
        }

        $this->HTTPResponse->redirect('/');
    }
}