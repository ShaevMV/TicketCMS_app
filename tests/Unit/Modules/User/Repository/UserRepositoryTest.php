<?php

namespace Tests\Unit\Modules\User\Repository;

use App\Ticket\Modules\User\Entity\UserEntity;
use Database\Factories\UserFactory;
use App\Ticket\Modules\User\Repository\UserRepository;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    private UserRepository $userRepository;

    /**
     * @throws Exception
     */
    public function testFindByEmail(): void
    {
        self::assertInstanceOf(
            UserEntity::class, $this->userRepository->getByEmail(UserFactory::EMAIL_ADMIN_FOR_TEST)
        );

        self::assertNull($this->userRepository->getByEmail('dsa'));

    }

    /**
     * @throws BindingResolutionException
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository = $this->app->make(UserRepository::class);
    }
}
