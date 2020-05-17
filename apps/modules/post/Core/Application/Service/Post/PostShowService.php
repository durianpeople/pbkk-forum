<?php

namespace Module\Post\Core\Application\Service\Post;

use Module\Post\Core\Application\Response\Post\PostInfo;
use Module\Post\Core\Application\Response\Comment\CommentInfo;
use Module\Post\Core\Application\Request\Post\PostShowRequest;
use Module\Post\Core\Domain\Interfaces\IPostRepository;
use Module\Post\Core\Domain\Interfaces\IUserRepository;
use Module\Post\Core\Domain\Model\Value\PostID;
use Phalcon\Di\Injectable;

class PostShowService extends Injectable
{
    public function execute(PostShowRequest $request): PostInfo
    {
        $repo = $this->di->get('postRepository');
        $user_repo = $this->di->get('userRepository');
        $post_id = new PostID($request->post_id);
        $post = $repo->findByID($post_id);

        $post_info = new PostInfo;
        $post_info->post_id = $post->id->getID();
        $post_info->post_title = $post->title;
        $post_info->post_content = $post->content;
        $post_info->post_author_id = $post->author_id->getID();
        $post_info->post_author_name = $user_repo->findByID($post->author_id)->username;
        $post_info->post_created_date = $post->created_date;  
        $post_info->post_votes = count($post->voted_members);

        $comments = [];
        foreach ($post->comments as $comment) {
          $comment_info = new CommentInfo;
          $comment_info->comment_id = $comment->id->getID();
          $comment_info->comment_content = $comment->content;
          $comment_info->comment_author_name = $user_repo->findByID($comment->author_id)->username;
          $comment_info->comment_author_id = $comment->author_id->getID();
          $comment_info->comment_created_date = $comment->created_date;
          $comment_info->comment_votes = count($comment->voted_members);
          $comments[] = $comment_info;
        }
        $post_info->post_comments = $comments;

        return $post_info;
    }
}
