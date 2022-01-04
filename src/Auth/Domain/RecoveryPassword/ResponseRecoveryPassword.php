<?php

declare(strict_types=1);

namespace Ticket\Auth\Domain\RecoveryPassword;

use JetBrains\PhpStorm\ArrayShape;

final class ResponseRecoveryPassword
{
    /** @var string Сгенерированный токен */
    private string $token;

    public function __construct(
       readonly public bool $success, // флаг того, что письмо отправлено на почту
       readonly public string $userMessage // Пользовательское сообщение
    ){}

    #[ArrayShape(['success' => "bool", 'userMessage' => "string"])]
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
