<?php

declare(strict_types=1);

namespace App\Ticket\Modules\Auth\Aggregate;

use App\Ticket\Modules\Auth\Entity\CredentialsDto;
use App\Ticket\Modules\Auth\Entity\Token;
use App\Ticket\Modules\Auth\Exception\ExceptionAuth;
use App\Ticket\Modules\Auth\Service\AuthService;
use Tymon\JWTAuth\JWTGuard;

final class AuthAggregate
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     *  Получить пользователя
     *
     * @throws ExceptionAuth
     */
    public function getTokenUser(CredentialsDto $credentialsDto): Token
    {
        return $this->authService->getTokenUser($credentialsDto);
    }

    public function refreshToken(JWTGuard $auth): Token
    {
        return $this->authService->refreshToken($auth);
    }
}
