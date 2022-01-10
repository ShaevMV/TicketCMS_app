<?php

namespace Ticket\User\Application\User;

use DomainException;
use Ticket\User\Domain\UserAggregate;
use Ticket\User\Domain\UserEntity;
use Ticket\User\Domain\UserRepository;
use Webpatser\Uuid\Uuid;

class GetUser
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function findById(Uuid $uuid): UserAggregate
    {
        $userEntity = $this->userRepository->findById($uuid);
        if ($userEntity instanceof UserEntity) {
            return new UserAggregate($userEntity);
        }

        throw new DomainException('Не верный тип ' . gettype($userEntity) . ' в место '. UserEntity::class);
    }
}
