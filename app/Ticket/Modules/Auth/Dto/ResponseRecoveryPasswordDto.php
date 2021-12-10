<?php

declare(strict_types=1);

namespace App\Ticket\Modules\Auth\Dto;

final class ResponseRecoveryPasswordDto
{
    /** @var bool флаг того, что письмо отправлено на почту */
    private bool $success;
    /** @var string Пользовательское сообщение */
    private string $userMessage;
    /** @var string Сгенерированный токен */
    private string $token;

    public function __construct(bool $success, string $userMessage)
    {
        $this->success = $success;
        $this->userMessage = $userMessage;
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'userMessage' => $this->userMessage,
        ];
    }

    public function setToken(string $token): self
    {
        $this->token = $token;
        return $this;
    }

    public function getToken(): string
    {
        return $this->token;
    }
}
