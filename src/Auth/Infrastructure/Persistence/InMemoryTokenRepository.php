<?php

namespace Ticket\Auth\Infrastructure\Persistence;

use DomainException;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\Auth;
use Ticket\Auth\Domain\Authenticate\AuthRepository;
use Ticket\Auth\Domain\Authenticate\CredentialsDto;
use Ticket\Auth\Domain\Authenticate\ExceptionAuth;
use Ticket\Auth\Domain\Token\Token;
use Ticket\Auth\Domain\Token\TokenRepository;
use Tymon\JWTAuth\Factory;
use Tymon\JWTAuth\JWTGuard;

use function app;
use function auth;

class InMemoryTokenRepository implements AuthRepository, TokenRepository
{
    /** @var int Время жизни токена */
    private const LIFE_TIME = 60;
    private JWTGuard $JWTGuard;

    public function __construct()
    {
        /** @var JWTGuard $JWTGuard */
        $JWTGuard = Auth::guard('api');
        if ($JWTGuard instanceof JWTGuard) {
            $this->JWTGuard = $JWTGuard;
        } else {
            throw new DomainException('Не реализована служба авторизации');
        }
    }

    /**
     * @throws ExceptionAuth
     */
    public function authUser(CredentialsDto $username): Token
    {
        if (!$token = auth()->attempt($username->toArray())) {
            throw new ExceptionAuth('Не верный логин или пароль');
        }

        return $this->getToken((string)$token);
    }

    private function getToken(string $token): Token
    {
        /** @var Container $auth */
        $auth = app('auth');
        /** @var  Factory $jwtAuth */
        $jwtAuth = $auth->factory('');

        return new Token(
            $token,
            $jwtAuth->getTTL() * self::LIFE_TIME
        );
    }

    /**
     * @return Token
     */
    public function refreshToken(): Token
    {
        return $this->getToken($this->JWTGuard->refresh());
    }

    public function logoutUser(): void
    {
        $this->JWTGuard->logout();
    }
}
