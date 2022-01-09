<?php

namespace Ticket\Auth\Tests\Token;


use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Bus;
use JetBrains\PhpStorm\Pure;
use Tests\TestCase;
use Ticket\Auth\Application\Token\RefreshingToken;
use Ticket\Auth\Application\Token\RefreshingTokenCommand;
use Ticket\Auth\Domain\Token\Token;
use Ticket\Auth\Domain\Token\TokenRepository;
use Ticket\Auth\Infrastructure\Persistence\InMemoryTokenRepository;
use Ticket\Auth\Tests\TokenTestCase;

use Tymon\JWTAuth\JWTGuard;

class RefreshingTokenTest extends TestCase
{
    public function testRefresh(): void
    {
        $token = $this->refreshingToken->refresh($this->createMock(JWTGuard::class));

        self::assertEquals('test', $token->getAccessToken());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->refreshingToken = new RefreshingToken(
            new class implements TokenRepository {
                use TokenTestCase;
                #[Pure]
                public function refreshToken(JWTGuard $auth): Token
                {
                    return $this->getToken();
                }
            }
        );
    }

    public function testCommand(): void
    {
        $this->app->bind(TokenRepository::class, InMemoryTokenRepository::class);

        Auth::login(User::first());
        /** @var Token $token */
        $token = Bus::dispatchNow(new RefreshingTokenCommand(Auth::guard()));
        self::assertNotEmpty($token->getAccessToken());
    }
}
