<?php

declare(strict_types=1);

namespace App\Ticket\Modules\Auth\Aggregate;

use App\Ticket\Modules\Auth\Dto\ResponseRecoveryPasswordDto;
use App\Ticket\Modules\Auth\Dto\UserDataForNewPasswordDto;
use App\Ticket\Modules\Auth\Entity\CredentialsDto;
use App\Ticket\Modules\Auth\Entity\Token;
use App\Ticket\Modules\Auth\Exception\DomainExceptionRecoveryPassword;
use App\Ticket\Modules\Auth\Exception\ExceptionAuth;
use App\Ticket\Modules\Auth\Service\AuthService;
use App\Ticket\Modules\Auth\Service\UserRecoveryPasswordService;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\JWTGuard;

final class AuthAggregate
{
    private AuthService $authService;
    private UserRecoveryPasswordService $userRecoveryPasswordService;

    public function __construct(
        AuthService                 $authService,
        UserRecoveryPasswordService $userRecoveryPasswordService
    )
    {
        $this->authService = $authService;
        $this->userRecoveryPasswordService = $userRecoveryPasswordService;
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

    /**
     * Обновить токен
     *
     * @param JWTGuard $auth
     * @return Token
     */
    public function refreshToken(JWTGuard $auth): Token
    {
        return $this->authService->refreshToken($auth);
    }

    /**
     * @param string $email
     * @return ResponseRecoveryPasswordDto
     * @throws DomainExceptionRecoveryPassword
     */
    public function sendLinkForRecoveryPassword(string $email): ResponseRecoveryPasswordDto
    {
        return $this->userRecoveryPasswordService->requestRestoration($email);
    }

    /**
     * @throws DomainExceptionRecoveryPassword
     * @throws TokenInvalidException
     */
    public function passwordReset(UserDataForNewPasswordDto $dataForNewPasswordDto): ResponseRecoveryPasswordDto
    {
        return $this->userRecoveryPasswordService->sendNewPassword($dataForNewPasswordDto);
    }
}
