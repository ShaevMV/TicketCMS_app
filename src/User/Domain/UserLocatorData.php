<?php

declare(strict_types=1);

namespace Ticket\User\Domain;

use Illuminate\Contracts\Auth\StatefulGuard;
use JetBrains\PhpStorm\Pure;
use Tymon\JWTAuth\JWTGuard;
use Webpatser\Uuid\Uuid;

final class UserLocatorData
{
    public function __construct(
        private ?Uuid     $uuid = null,
        private JWTGuard|null|StatefulGuard $auth = null,
    ){}

    public function getUuid(): ?Uuid
    {
        if (null !== $this->uuid) {
            return $this->uuid;
        }

        if (null !== $this->auth?->id()) {
            return Uuid::import($this->auth->id());
        }

        return null;
    }

    #[Pure]
    public static function fromStateAuth(JWTGuard|StatefulGuard $JWTGuard): self
    {
        return new self(null, $JWTGuard);
    }
}
