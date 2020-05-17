<?php

namespace Module\Post\Core\Application\Service\Comment;

use Module\Post\Core\Application\Request\Comment\CommentDeleteRequest;
use Module\Post\Core\Domain\Interfaces\ICommentRepository;
use Module\Post\Core\Domain\Model\Value\CommentID;
use Module\Post\Core\Domain\Model\Value\UserID;
use Module\Post\Core\Domain\Model\Entity\Comment;
use Phalcon\Di\Injectable;

class CommentDeleteService extends Injectable
{
    public function execute(CommentDeleteRequest $request): bool
    {
        $comment_repo = $this->di->get('commentRepository');
        $comment_id = new CommentID($request->comment_id);
        $user_id = new UserID($request->comment_author_id);
        if ($comment_repo->isAuthorizedComment($comment_id, $user_id)) {
          $comment = $comment_repo->findByID($comment_id);
          $comment->will_be_deleted = true;        
          return $comment_repo->persist($comment); 
        } else return false;
    }
}
