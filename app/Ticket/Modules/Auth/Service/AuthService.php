<?php

declare(strict_types=1);

namespace App\Ticket\Modules\Auth\Service;

use App\Ticket\Modules\Auth\Entity\CredentialsDto;
use App\Ticket\Modules\Auth\Entity\Token;
use App\Ticket\Modules\Auth\Exception\ExceptionAuth;
use Illuminate\Contracts\Container\Container;
use Tymon\JWTAuth\Factory;
use Tymon\JWTAuth\JWTGuard;

/**
 * Class AuthService
 *
 * Сервис для авторизации пользователя
 *
 * @package App\Ticket\Modules\Auth\Service
 */
final class AuthService
{
    /** @var int Время жизни токена */
    private const LIFE_TIME = 60;

    /**
     * @param CredentialsDto $credentialsDto
     * @return Token
     * @throws ExceptionAuth
     */
    public function getTokenUser(CredentialsDto $credentialsDto): Token
    {
        if (!$token = auth()->attempt($credentialsDto->toArray())) {
            throw new ExceptionAuth('Не верный логин или пароль');
        }

        return $this->getToken((string)$token);
    }

    /**
     * @param string $token
     *
     * @return Token
     */
    private function getToken(string $token): Token
    {
        /** @var Container $auth */
        $auth = app('auth');
        /** @var  Factory $jwtAuth */
        $jwtAuth = $auth->factory('');

        return (new Token())
            ->setExpiresIn($jwtAuth->getTTL() * self::LIFE_TIME)
            ->setAccessToken($token);
    }

    /**
     * @param JWTGuard $auth
     *
     * @return Token
     */
    public function refreshToken(JWTGuard $auth): Token
    {
        $token = $auth->refresh();

        return $this->getToken($token);
    }
}
