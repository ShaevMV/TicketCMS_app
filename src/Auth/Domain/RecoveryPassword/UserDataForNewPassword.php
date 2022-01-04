<?php

declare(strict_types=1);

namespace Ticket\Auth\Domain\RecoveryPassword;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

final class UserDataForNewPassword
{
    public function __construct(
        readonly private string $token,
        readonly private string $email,
        readonly private string $password,
        readonly private string $password_confirmation,
    ){}

    #[ArrayShape(['token' => "string", 'email' => "string", 'password' => "string", 'password_confirmation' => "string"])]
    public function toArray(): array
    {
        return [
            'token' => $this->token,
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password_confirmation
        ];
    }

    #[Pure]
    public static function fromState(array $data): self
    {
        return new self(
            $data['token'],
            $data['email'],
            $data['password'],
            $data['password_confirmation']
        );
    }
}
