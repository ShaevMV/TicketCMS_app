<?php

namespace Ticket\Auth\Domain\Token;

use Tymon\JWTAuth\JWTGuard;

interface TokenRepository
{
    public function refreshToken(JWTGuard $auth): Token;
}
