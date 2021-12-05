<?php


namespace Controller;


use Entity\Post;
use Model\ImageManager;
use Model\PostManager;
use Model\UserManager;

class PostController extends Controller
{

    public function executeShowMany(int $number = 5)
    {
        $manager = new PostManager();
        $index = $manager->getPosts($number);

        return $this->render('Page d\'accueil', $index, 'FrontEnd/index');
    }

    public function executeShowOne()
    {
        $manager = new PostManager();
        $article = $manager->getPostById($this->params['id']);

        if (!$article) {
            $this->HTTPResponse->redirect('/');
        }

        return $this->render($article->getTitle(), ['article' => $article], 'FrontEnd/show');
    }

    public function executeWritePost()
    {
        if (SecurityController::isAuthenticated() && !isset($_POST['title']) && !isset($_POST['content'])) {
            return $this->render('Write new article', [], 'Admin/write-article');
        } elseif (SecurityController::isAuthenticated() && isset($_POST['title']) && isset($_POST['content'])) {
            $newPost = new Post(array(
                'title' => $_POST['title'],
                'content' => $_POST['content'],
                'authorId' => SecurityController::getLoggedUser()->getId()
            ));

            $imageManager = new ImageManager();
            $image = $imageManager->uploadImage($_FILES['image']);
            if ($image) {
                $newPost->setImageId($image->getId());
            }

            $manager = new PostManager();
            $newPost = $manager->addPost($newPost);

            $this->HTTPResponse->redirect('/article/' . $newPost->getId());
        }

        $this->HTTPResponse->redirect('/login');
    }

    public function executeDeletePost(): void
    {
        $postManager = new PostManager();
        $post = $postManager->getPostById($this->params['id']);

        if (SecurityController::isAuthenticated() && SecurityController::getLoggedUser()->havePostRights($post)) {
            $postManager->deletePost($this->params['id']);
        }

        $this->HTTPResponse->redirect('/');
    }

    public function executeUpdatePost()
    {
        $manager = new PostManager();
        $post = $manager->getPostById($this->params['id']);
        if (SecurityController::isAuthenticated() && SecurityController::getLoggedUser()->havePostRights($post) && !isset($_POST['title'])) {
            return $this->render('Update article', [
                'article' => $post
            ], 'Admin/update-article');
        } elseif (SecurityController::isAuthenticated() && SecurityController::getLoggedUser()->havePostRights($post) && isset($_POST['title']) && isset($_POST['content'])) {
            $newPost = new Post(array(
                'id' => $this->params['id'],
                'title' => $_POST['title'],
                'content' => $_POST['content']
            ));

            $imageManager = new ImageManager();
            $image = $imageManager->uploadImage($_FILES['image']);

            if ($image) {
                $newPost->setImageId($image->getId());
            } else {
                $newPost->setImageId($post->getImageId());
            }

            $manager->updatePost($newPost);
        }

        $this->HTTPResponse->redirect('/article/' . $this->params['id']);
    }
}
