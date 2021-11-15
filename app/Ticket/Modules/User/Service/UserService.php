<?php

declare(strict_types=1);

namespace App\Ticket\Modules\User\Service;

use App\Ticket\Modules\User\Entity\UserEntity;
use App\Ticket\Modules\User\Repository\UserRepository;
use Exception;
use Webpatser\Uuid\Uuid;

final class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @throws Exception
     */
    public function createUser(UserEntity $userEntity): UserEntity
    {
        $userEntity->setPassword(bcrypt($userEntity->getPassword()));
        $uuid = $this->userRepository->create($userEntity);

        return $userEntity->setId($uuid);
    }
}
