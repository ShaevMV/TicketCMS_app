<?php

declare(strict_types=1);

namespace App\Ticket\Modules\User\Service;

use App\Ticket\Modules\User\Entity\UserEntity;
use App\Ticket\Modules\User\Repository\UserRepository;
use Webpatser\Uuid\Uuid;

final class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createUser(UserEntity $userEntity): bool
    {
        $userEntity->setPassword(bcrypt($userEntity->getPassword()));

        return $this->userRepository->create($userEntity) instanceof Uuid;
    }
}
