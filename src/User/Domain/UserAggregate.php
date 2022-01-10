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

    public function toArray(): array
    {
        return $this->userEntity->toArray();
    }
}
