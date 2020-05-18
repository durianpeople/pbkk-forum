<?php

namespace Module\Post\Core\Application\Service\Comment;

use Module\Post\Core\Application\Request\Comment\CommentVoteRequest;
use Module\Post\Core\Domain\Interfaces\IPostRepository;
use Module\Post\Core\Domain\Interfaces\ICommentRepository;
use Module\Post\Core\Domain\Interfaces\IUserRepository;
use Module\Post\Core\Domain\Model\Value\PostID;
use Module\Post\Core\Domain\Model\Value\CommentID;
use Module\Post\Core\Domain\Model\Value\UserID;
use Module\Post\Core\Domain\Model\Entity\Post;
use Phalcon\Di\Injectable;

class CommentVoteService extends Injectable
{
    public function execute(CommentVoteRequest $request): bool
    {
        $comment_repo = $this->di->get('commentRepository');
        $comment = $comment_repo->findByID(new CommentID($request->voted_comment_id));
        if ($comment->addVote(new UserID($request->voter_id))) {
            return $comment_repo->persist($comment);
        }
        return false;
    }
}
