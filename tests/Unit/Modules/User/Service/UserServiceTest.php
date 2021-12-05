<?php

declare(strict_types=1);

namespace Tests\Unit\User\Service;

use App\Ticket\Modules\User\Entity\UserEntity;
use App\Ticket\Modules\User\Service\UserService;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use DatabaseTransactions;

    private UserService $userService;

    /**
     * @throws Exception
     */
    public function testCreateUser(): void
    {
        $userEntity = UserEntity::fromState([
            'name' => 'test',
            'email' => 'test@email.ru',
            'password' => 'test'
        ]);

        $userEntity = $this->userService->createUser($userEntity);
        self::assertNotNull($userEntity->getId());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->userService = $this->app->make(UserService::class);
    }
}
