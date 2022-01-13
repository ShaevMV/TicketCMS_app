<?php

declare(strict_types=1);

namespace Ticket\Auth\Application\Authenticate;

use Illuminate\Console\Command;

class ReAuthenticateUserCommand extends Command
{
    protected $signature = 'auth:reAuthenticate';

    protected $description = 'Раз авторизация пользователя';

    public function handle(AuthenticateUser $authenticateUser): void
    {
        $authenticateUser->reAuthenticate();
    }
}
