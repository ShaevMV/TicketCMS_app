<?php

namespace Ticket\User\Domain;

use JetBrains\PhpStorm\Pure;
use Webpatser\Uuid\Uuid;

class UserAggregate
{
    public function __construct(
        private UserEntity $userEntity
    ){}

    #[Pure]
    public function getId(): Uuid
    {
        return $this->userEntity->getId();
    }

    /**
     * @return UserEntity
     */
    public function getUserEntity(): UserEntity
    {
        return $this->userEntity;
    }

}
