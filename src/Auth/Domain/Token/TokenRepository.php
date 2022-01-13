<?php

namespace Ticket\Auth\Domain\Token;

interface TokenRepository
{
    public function refreshToken(): Token;
}
