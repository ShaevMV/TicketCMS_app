<?php

declare(strict_types=1);

namespace Ticket\Auth\Application\Authenticate;

use Ticket\Auth\Domain\Authenticate\AuthRepository;
use Ticket\Auth\Domain\Authenticate\CredentialsDto;
use Ticket\Auth\Domain\Token\Token;

class AuthenticateUser
{
    public function __construct(private AuthRepository $repository)
    {
    }

    public function authenticate(CredentialsDto $credentialsDto): Token
    {
        return $this->repository->getTokenUser($credentialsDto);
    }
}
