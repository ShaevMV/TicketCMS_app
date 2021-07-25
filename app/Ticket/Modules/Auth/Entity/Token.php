<?php

declare(strict_types=1);

namespace App\Ticket\Modules\Auth\Entity;

use App\Ticket\Entity\AbstractionEntity;

/**
 * Class Token
 *
 * Сущность токена
 *
 * @package App\Ticket\Modules\Auth\Entity
 */
final class Token extends AbstractionEntity
{
    /** @var string токен */
    protected string $accessToken;

    /** @var string тип токена */
    protected string $tokenType = 'bearer';

    /** @var int время жизни токена */
    protected int $expiresIn;

    public static function fromState(array $data): self
    {
        return (new self())
            ->setAccessToken($data['access_token'])
            ->setExpiresIn($data['token_type'])
            ->setExpiresIn($data['expires_in']);
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * @param string $accessToken
     *
     * @return self
     */
    public function setAccessToken(string $accessToken): self
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * @return string
     */
    public function getTokenType(): string
    {
        return $this->tokenType;
    }

    /**
     * @param string $tokenType
     *
     * @return self
     */
    public function setTokenType(string $tokenType): self
    {
        $this->tokenType = $tokenType;

        return $this;
    }

    /**
     * @return int
     */
    public function getExpiresIn(): int
    {
        return $this->expiresIn;
    }

    /**
     * @param int $expiresIn
     *
     * @return self
     */
    public function setExpiresIn(int $expiresIn): self
    {
        $this->expiresIn = $expiresIn;

        return $this;
    }
}
