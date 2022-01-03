<?php

declare(strict_types=1);

namespace Ticket\Auth\Domain\Token;

use JetBrains\PhpStorm\Pure;
use Ticket\Shared\Domain\Entity\AbstractionEntity;

/**
 * Class Token
 *
 * Сущность токена
 *
 * @package App\Ticket\Modules\Auth\Entity
 */
final class Token extends AbstractionEntity
{
    public function __construct(
        /** @var string токен */
        protected string $accessToken,
        /** @var int Время жизни токена */
        protected int $expiresIn,
        /** @var string тип токена */
        protected string $tokenType = 'bearer',
    )
    {
    }

    #[Pure] public static function fromState(array $data): self
    {
        return new self(
            $data['access_token'],
            $data['expires_in'],
            $data['token_type']
        );
    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    public function setAccessToken(string $accessToken): self
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    public function getTokenType(): string
    {
        return $this->tokenType;
    }

    public function setTokenType(string $tokenType): self
    {
        $this->tokenType = $tokenType;

        return $this;
    }

    public function getExpiresIn(): int
    {
        return $this->expiresIn;
    }

    public function setExpiresIn(int $expiresIn): self
    {
        $this->expiresIn = $expiresIn;

        return $this;
    }
}
