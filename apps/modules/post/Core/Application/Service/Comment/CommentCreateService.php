<?php

namespace Module\Post\Core\Application\Service\Comment;

use Module\Post\Core\Application\Request\Comment\CommentCreateRequest;
use Module\Post\Core\Domain\Interfaces\ICommentRepository;
use Module\Post\Core\Domain\Model\Value\PostID;
use Module\Post\Core\Domain\Model\Value\UserID;
use Module\Post\Core\Domain\Model\Value\CommentID;
use Module\Post\Core\Domain\Model\Entity\Comment;
use Phalcon\Di\Injectable;

class CommentCreateService extends Injectable
{
    public function execute(CommentCreateRequest $request): bool
    {
        $repo = $this->di->get('commentRepository');

        $comment = Comment::create($request->comment_content, new UserID($request->comment_author_id), new PostID($request->comment_post_id));
        
        return $repo->persist($comment); 

    }
}
