<?php

namespace Ticket\Auth\Application\Token;

use Illuminate\Console\Command;
use Ticket\Auth\Domain\Token\Token;
use Tymon\JWTAuth\JWTGuard;

class RefreshingTokenCommand extends Command
{
    protected $signature = 'auth:refresh';

    protected $description = 'Обновить токен';


    public function __construct(
        private JWTGuard $auth
    ){
        parent::__construct();
    }

    public function handle(RefreshingToken $refreshingToken): Token
    {
        return $refreshingToken->refresh($this->auth);
    }
}
