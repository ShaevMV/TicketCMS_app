<?php

namespace Ticket\User\Infrastructure\Persistence;

use App\Models\User;
use Ticket\Shared\Domain\Entity\EntityInterface;
use Ticket\Shared\Domain\Repository\BaseRepository;
use Ticket\User\Domain\UserEntity;
use Ticket\User\Domain\UserRepository;

class InMemoryUserRepository extends BaseRepository implements UserRepository
{
    protected $model;

    public function __construct(
        User $model
    ){
        $this->model = $model;
    }

    protected function build(array $data): EntityInterface
    {
        return UserEntity::fromState($data);
    }
}
