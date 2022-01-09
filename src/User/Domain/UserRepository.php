<?php

namespace Ticket\User\Domain;

use Ticket\Shared\Domain\Entity\EntityInterface;
use Webpatser\Uuid\Uuid;

interface UserRepository
{
    /**
     * Создать нового пользователя и вывести его Uuid
     *
     * @param UserEntity $userEntity
     * @return Uuid
     */
    public function create(UserEntity $userEntity): Uuid;

    public function findById(Uuid $id): EntityInterface;
}
