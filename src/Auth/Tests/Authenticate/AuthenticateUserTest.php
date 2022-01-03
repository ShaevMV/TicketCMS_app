<?php

declare(strict_types=1);

namespace Ticket\Auth\Tests\Authenticate;

use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\Bus;
use JetBrains\PhpStorm\Pure;
use Tests\TestCase;
use Ticket\Auth\Application\Authenticate\AuthenticateUser;
use Ticket\Auth\Application\Authenticate\AuthenticateUserCommand;
use Ticket\Auth\Domain\Authenticate\AuthRepository;
use Ticket\Auth\Domain\Authenticate\CredentialsDto;
use Ticket\Auth\Domain\Token\Token;
use Ticket\Auth\Infrastructure\Persistence\InMemoryTokenRepository;
use Ticket\Auth\Tests\TokenTestCase;

class AuthenticateUserTest extends TestCase
{
    private AuthenticateUser $authenticateUser;

    public function testAuthenticate(): void
    {
        $token = $this->authenticateUser->authenticate(new CredentialsDto('test', 'test'));

        self::assertEquals('test', $token->getAccessToken());
    }

    public function testCommand(): void
    {
        $this->app->bind(AuthRepository::class, InMemoryTokenRepository::class);
        /** @var Token $token */
        $token = Bus::dispatchNow(new AuthenticateUserCommand(CredentialsDto::fromState([
            'email' => UserSeeder::USER_LOGIN_FOR_TEST,
            'password' => UserSeeder::USER_PASSWORD_FOR_TEST,
        ])));

        self::assertNotEmpty($token->getAccessToken());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->authenticateUser = new AuthenticateUser(
            new class implements AuthRepository {
                use TokenTestCase;

                #[Pure] public function getTokenUser(CredentialsDto $username): Token
                {
                    return $this->getToken();
                }
            }
        );
    }
}
