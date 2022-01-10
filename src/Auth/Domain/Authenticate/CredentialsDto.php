<?php

declare(strict_types=1);

namespace Ticket\Auth\Domain\Authenticate;

use App\Ticket\Entity\AbstractionEntity;
use JetBrains\PhpStorm\Pure;

/**
 * Class CredentialsDto
 *
 * Данные для авторизации
 *
 * @package App\Ticket\Modules\Auth\Dto
 */
final class CredentialsDto extends AbstractionEntity
{
    public function __construct(
        public string $email,
        public string $password,
    ){}

    #[Pure]
    public static function fromState(array $data): self
    {
        return new self(
            $data['email'],
            $data['password']
        );
    }
}
