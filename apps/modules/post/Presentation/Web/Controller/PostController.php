<?php

namespace Module\Post\Presentation\Web\Controller;

use Phalcon\Mvc\Controller;

use Module\Post\Core\Application\Service\Post\PostListService;
use Module\Post\Core\Application\Service\Post\PostShowService;
use Module\Post\Core\Application\Service\Post\PostCreateService;
use Module\Post\Core\Application\Service\Post\PostDeleteService;
use Module\Post\Core\Application\Service\Post\PostVoteService;
use Module\Post\Core\Application\Service\Comment\CommentShowService;
use Module\Post\Core\Application\Service\Comment\CommentVoteService;
use Module\Post\Core\Application\Service\Comment\CommentCreateService;
use Module\Post\Core\Application\Service\Comment\CommentDeleteService;
use Module\Post\Core\Application\Request\Post\PostShowRequest;
use Module\Post\Core\Application\Request\Post\PostCreateRequest;
use Module\Post\Core\Application\Request\Post\PostDeleteRequest;
use Module\Post\Core\Application\Request\Post\PostVoteRequest;
use Module\Post\Core\Application\Request\Comment\CommentShowRequest;
use Module\Post\Core\Application\Request\Comment\CommentVoteRequest;
use Module\Post\Core\Application\Request\Comment\CommentCreateRequest;
use Module\Post\Core\Application\Request\Comment\CommentDeleteRequest;
use Module\Post\Core\Exception\NotFoundException;
use Module\Post\Core\Exception\DuplicateVoteException;

class PostController extends Controller
{
    public function indexAction()
    {
        $post_list_service = new PostListService;
        if (!$this->session->has('user_info')) {
            $this->flashSession->error("You need to login first.");
            return $this->response->redirect('/login');
        } else {
            try {
                $user_info = $this->session->get('user_info');
                $posts = $post_list_service->execute();
                $this->view->setVar('user_info', $user_info);
                $this->view->setVar('posts', $posts);
            } catch (NotFoundException $e) {
                $this->flashSession->error($e->getMessage());
                $this->session->remove('user_info');
                $this->response->redirect("/");
            }
        }
    }

    public function createAction()
    {

        if ($this->session->has('user_info') === false)
            return $this->response->redirect("/login");
        if ($this->request->isPost()) {
            $user = $auth_service->getUser();

            $request = new PostCreateRequest;
            $request->post_author_id = $user->id->getID();
            $request->post_title = $this->request->getPost('post_title', 'string');
            $request->post_content = $this->request->getPost('post_content', 'string');

            $service = new PostCreateService;
            $service->execute($request);
            $this->flashSession->success('Post Created');
            $this->response->redirect('/post');
        } else {
            $user_info = $this->session->get('user_info');
            $this->view->setVar('user_info', $user_info);
        }
    }

    public function showAction()
    {
        if (!$this->session->has('user_info')) {
            $this->flashSession->error("You need to login first.");
            return $this->response->redirect('/login');
        }
        $request = new PostShowRequest;
        $request->post_id = $this->request->get('id', 'string');

        $post_show_service = new PostShowService;
        try {
            $user_info = $this->session->get('user_info');
            $post_info = $post_show_service->execute($request);
            $this->view->setVar('post_info', $post_info);
            //$this->view->setVar('comment_list', $comment_list);
            $this->view->setVar('user_info', $user_info);
        } catch (NotFoundException $e) {
            $this->flashSession->error('Post not found.');
            $this->response->redirect('/post');
        }
    }

    public function deleteAction()
    {

        if ($this->session->has('user_info') === false)
            return $this->response->redirect('/login');

        try {
            $user = $auth_service->getUser();

            $request = new PostDeleteRequest;
            $request->post_id = $this->request->get('id', 'string');
            $request->post_author_id = $user->id->getID();

            $service = new PostDeleteService;
            if ($service->execute($request)) {
                $this->flashSession->success('Post Deleted');
            } else {
                $this->flashSession->error('Unauthorized User Access');
            }

            $this->response->redirect("/post");
        } catch (\Exception $e) {
            echo $e->getMessage();
            die();
            $this->flashSession->error($e->getMessage());
            $this->response->redirect('/post');
        }
    }

    public function voteAction()
    {

        if ($this->session->has('user_info') === false)
            return $this->response->redirect('/login');

        if ($this->request->get('type', 'string') == 'post') {
            $request = new PostVoteRequest;
            $request->voter_id = $this->session->get('user_info')->id;
            $request->voted_post_id = $this->request->get('id', 'string');

            $service = new PostVoteService;
            try {
                $service->execute($request);
                $this->flashSession->success('Voted succesfully');
            } catch (DuplicateVoteException $e) {
                $this->flashSession->error('You can\'t voted multiple times');
            } catch (NotFoundException $e) {
                $this->flashSession->error($e->getMessage());
            }
        } else if ($this->request->get('type', 'string') == 'comment') {
            $request = new CommentVoteRequest;
            $request->voter_id = $this->session->get('user_info')->id;
            $request->voted_comment_id = $this->request->get('id', 'string');

            $service = new CommentVoteService;
            try {
                $service->execute($request);
                $this->flashSession->success('Voted succesfully');
            } catch (DuplicateVoteException $e) {
                $this->flashSession->error('You can\'t voted multiple times');
            } catch (NotFoundException $e) {
                $this->flashSession->error($e->getMessage());
            }
        }
        return $this->response->redirect($_SERVER['HTTP_REFERER']);
    }

    public function commentAction()
    {

        if ($this->session->has('user_info') === false)
            return $this->response->redirect('/login');

        $request = new CommentCreateRequest;
        $request->comment_author_id = $this->session->get('user_info')->id;
        $request->comment_post_id = $this->request->getPost('post_id', 'string');
        $request->comment_content = $this->request->getPost('comment_content', 'string');

        $service = new CommentCreateService;
        try {
            $service->execute($request);
            $this->flashSession->success('Comment Created Successfully');
        } catch (\Exception $e) {
            $this->flashSession->error($e->getMessage());
        }
        return $this->response->redirect('/post/show?id=' . $request->comment_post_id);
    }

    public function uncommentAction()
    {

        if ($this->session->has('user_info') === false)
            return $this->response->redirect('/login');

        try {
            $user = $auth_service->getUser();

            $request = new CommentDeleteRequest;
            $request->comment_id = $this->request->get('id', 'string');
            $request->comment_author_id = $user->id->getID();

            $service = new CommentDeleteService;
            $service->execute($request);
            $this->flashSession->success('Comment Deleted');
        } catch (\Exception $e) {

            $this->flashSession->error($e->getMessage());
        }
        return $this->response->redirect($_SERVER['HTTP_REFERER']);
    }
}
