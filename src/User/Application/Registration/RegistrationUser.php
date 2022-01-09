<?php

namespace Ticket\User\Application\Registration;

use Ticket\User\Domain\UserAggregate;
use Ticket\User\Domain\UserEntity;
use Ticket\User\Domain\UserRepository;
use Webpatser\Uuid\Uuid;

class RegistrationUser
{
     public function __construct(
         private UserRepository $userRepository
     ){}

    public function createNewUser(UserEntity $userEntity): UserAggregate
    {
        $id = $this->userRepository->create($userEntity);

        return new UserAggregate($userEntity->setId($id));
    }
}
