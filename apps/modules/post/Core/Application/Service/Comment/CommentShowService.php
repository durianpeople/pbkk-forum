<?php

namespace Module\Post\Core\Application\Service\Comment;

use Module\Post\Core\Application\Response\Comment\CommentInfo;
use Module\Post\Core\Application\Request\Comment\CommentShowRequest;
use Module\Post\Core\Domain\Interfaces\IPostRepository;
use Module\Post\Core\Domain\Interfaces\ICommentRepository;
use Module\Post\Core\Domain\Interfaces\IUserRepository;
use Module\Post\Core\Domain\Model\Value\PostID;
use Module\Post\Core\Domain\Model\Value\CommentID;
use Phalcon\Di\Injectable;

class CommentShowService extends Injectable
{
    public function execute(CommentShowRequest $request): array
    {
        $repo = $this->di->get('commentRepository');
        $user_repo = $this->di->get('userRepository');
        $post_id = new PostID($request->post_id);
        $comments = $repo->findByPostID($post_id);
        
        $comment_list = [];
        
        foreach($comments as $comment) {
          $comment_info = new CommentInfo;
          $comment_info->comment_id = $comment->id->getID();
          $comment_info->comment_content = $comment->content;
          $comment_info->comment_author_id = $comment->author_id->getID();
          $comment_info->comment_author_name = $user_repo->findByID($comment->author_id)->username;
          $comment_info->comment_created_date = $comment->created_date;  
          //$comment_info->comment_votes = count($comment->voted_members);
          $comment_list[] = $comment_info;
        }

        return $comment_list;
    }
}
