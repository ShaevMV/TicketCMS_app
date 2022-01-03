<?php

namespace Tests\Feature\Auth;

use App\Ticket\Modules\Auth\Exception\ExceptionAuth;
use Database\Seeders\UserSeeder;
use Tests\TestCase;
use Ticket\Auth\Domain\Authenticate\CredentialsDto;
use Ticket\Infrastructure\Persistence\InMemoryTokenRepository;
use Tymon\JWTAuth\JWTGuard;

class TokenTest extends TestCase
{
    /**
     * @throws ExceptionAuth
     */
    public function testGetTokenUser(): string
    {
        $token = $this->inMemoryTokenRepository->getTokenUser(new CredentialsDto(
            UserSeeder::USER_LOGIN_FOR_TEST,
            UserSeeder::USER_PASSWORD_FOR_TEST
        ));

        self::assertNotEmpty($token->getAccessToken());

        return $token->getAccessToken();
    }


    /**
     * @depends testGetTokenUser
     */
    public function testRefresh(string $token): void
    {
        /** @var JWTGuard $auth */
        $auth = $this->createMock(JWTGuard::class);
        $token = $this->inMemoryTokenRepository->refreshToken(
            $auth->setToken($token)
        );

        self::assertNotEmpty($token->getAccessToken());
    }


    protected function setUp(): void
    {
        parent::setUp();

        $this->inMemoryTokenRepository = new InMemoryTokenRepository();
    }
}
