<?php

namespace Module\Forum\Core\Application\Service\User;

use Module\Forum\Core\Application\Request\User\AwardRequest;

use Module\Forum\Core\Domain\Interfaces\IUserRepository;
use Module\Forum\Core\Domain\Model\Value\Award;
use Module\Forum\Core\Domain\Model\Value\UserID;

class AwardService
{
    protected $user_repo;

    public function __construct(IUserRepository $user_repo)
    {
        $this->user_repo = $user_repo;
    }

    public function execute(AwardRequest $request)
    {
        $awardee = $this->user_repo->find(new UserID($request->awardee_id));
        $awardee->addAward(new Award(new UserID($request->awarder_id)));

        $this->user_repo->persist($awardee);
    }
}
