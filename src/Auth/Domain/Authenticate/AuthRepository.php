<?php

declare(strict_types=1);

namespace Ticket\Auth\Domain\Authenticate;

use Ticket\Auth\Domain\Token\Token;

interface AuthRepository
{
    public function authUser(CredentialsDto $username): Token;
    public function logoutUser(): void;
}
