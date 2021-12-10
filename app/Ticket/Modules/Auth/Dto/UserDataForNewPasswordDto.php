<?php

declare(strict_types=1);

namespace App\Ticket\Modules\Auth\Dto;

final class UserDataForNewPasswordDto
{
    private string $token;
    private string $email;
    private string $password;
    private string $password_confirmation;

    public function __construct(string $token, string $email, string $password, string $password_confirmation)
    {
        $this->token = $token;
        $this->email = $email;
        $this->password = $password;
        $this->password_confirmation = $password_confirmation;
    }

    public function toArray(): array
    {
        return [
            'token' => $this->token,
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password_confirmation
        ];
    }

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
