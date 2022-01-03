<?php

namespace Ticket\Auth\Tests\Token;


use JetBrains\PhpStorm\Pure;
use Tests\TestCase;
use Ticket\Auth\Application\Token\RefreshingToken;
use Ticket\Auth\Domain\Token\Token;
use Ticket\Auth\Domain\Token\TokenRepository;
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

                #[Pure] public function refreshToken(JWTGuard $auth): Token
                {
                    return $this->getToken();
                }
            }
        );
    }
}
