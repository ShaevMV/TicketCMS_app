<?php

namespace Ticket\Auth\Application\Token;

use Ticket\Auth\Domain\Token\Token;
use Ticket\Auth\Domain\Token\TokenRepository;
use Tymon\JWTAuth\JWTGuard;

class RefreshingToken
{
    public function __construct(
        private TokenRepository $tokenRepository,
    ){
    }

    public function refresh(): Token
    {
        return $this->tokenRepository->refreshToken();
    }
}
