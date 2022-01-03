<?php

namespace Ticket\Auth\Infrastructure\Persistence;

use App\Ticket\Modules\Auth\Exception\ExceptionAuth;
use Illuminate\Contracts\Container\Container;
use Ticket\Auth\Domain\Authenticate\AuthRepository;
use Ticket\Auth\Domain\Authenticate\CredentialsDto;
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

    /**
     * @throws ExceptionAuth
     */
    public function getTokenUser(CredentialsDto $username): Token
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
