<?php

declare(strict_types=1);

namespace Ticket\Auth\Application\Authenticate;

use Illuminate\Console\Command;
use Ticket\Auth\Domain\Authenticate\CredentialsDto;
use Ticket\Auth\Domain\Token\Token;

class AuthenticateUserCommand extends Command
{
    protected $signature = 'auth:authenticate';

    protected $description = 'Авторизация пользователя по логину и паролю';

    public function __construct(
        public CredentialsDto $credentialsDto,
    ){
        parent::__construct();
    }

    public function handle(AuthenticateUser $authenticateUser): Token
    {
        return $authenticateUser->authenticate($this->credentialsDto);
    }
}
