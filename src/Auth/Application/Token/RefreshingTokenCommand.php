<?php

namespace Ticket\Auth\Application\Token;

use Illuminate\Console\Command;
use Illuminate\Contracts\Auth\StatefulGuard;
use Ticket\Auth\Domain\Token\Token;
use Tymon\JWTAuth\JWTGuard;

class RefreshingTokenCommand extends Command
{
    protected $signature = 'auth:refresh';

    protected $description = 'Обновить токен';

    public function handle(RefreshingToken $refreshingToken): Token
    {
        return $refreshingToken->refresh();
    }
}
