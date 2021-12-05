<?php

declare(strict_types=1);

namespace App\Ticket\Modules\User\Repository;

use App\Models\User;
use App\Ticket\Entity\EntityInterface;
use App\Ticket\Modules\User\Entity\UserEntity;
use App\Ticket\Repository\BaseRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserRepository extends BaseRepository
{
    /**
     * @var User
     */
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * @throws Exception
     * @throws ModelNotFoundException
     */
    public function getByEmail(string $email): EntityInterface
    {
        $result = $this->model::where('email', $email)->firstOrFail();

        return $this->build($result->toArray());
    }

    /**
     * @throws Exception
     */
    protected function build(array $data): EntityInterface
    {
        return UserEntity::fromState($data);
    }
}
