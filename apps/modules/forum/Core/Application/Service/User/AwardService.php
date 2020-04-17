<?php

namespace Module\Forum\Core\Application\Service\User;

use Module\Forum\Core\Application\Request\User\AwardRequest;
use Module\Forum\Core\Domain\Interfaces\IUserRepository;
use Module\Forum\Core\Domain\Model\Value\Award;
use Module\Forum\Core\Domain\Model\Value\UserID;
use Phalcon\Di\Injectable;

class AwardService extends Injectable
{
    public function execute(AwardRequest $request)
    {
        /** @var IUserRepository */
        $user_repo = $this->di->get('userRepository');

        $awardee = $user_repo->find(new UserID($request->awardee_id));
        $awarder = $user_repo->find(new UserID($request->awarder_id));
        $awardee->addAward(new Award($awarder));

        $user_repo->persist($awardee);
    }
}