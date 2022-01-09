<?php

declare(strict_types=1);

namespace Ticket\User\Tests\Registration;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;
use Ticket\User\Application\Registration\RegistrationUserCommand;
use Ticket\User\Application\User\GetUserCommand;
use Ticket\User\Domain\UserAggregate;
use Ticket\User\Domain\UserEntity;
use Ticket\User\Domain\UserRepository;
use Ticket\User\Infrastructure\Persistence\InMemoryUserRepository;

class RegistrationUserTest extends TestCase
{
    use DatabaseTransactions;

    public function testCreateUser(): void
    {
        $this->app->bind(UserRepository::class, InMemoryUserRepository::class);

        /** @var UserAggregate $result */
        $resultAfterRegistration = Bus::dispatchNow(new RegistrationUserCommand(
            new UserEntity(
                'test',
                'test@test.ru',
                'test'
            )
        ));

        self::assertNotEmpty($resultAfterRegistration->getId());
        /** @var UserAggregate $result */
        $result = Bus::dispatchNow(new GetUserCommand($resultAfterRegistration->getId()));
        self::assertEquals('test', $result->getUserEntity()->toArray()['name']);
    }
}
