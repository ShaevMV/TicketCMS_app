<?php

declare(strict_types=1);

namespace App\Ticket\Modules\Auth\Entity;

use App\Ticket\Entity\AbstractionEntity;

/**
 * Class CredentialsDto
 *
 * Данные для авторизации
 *
 * @package App\Ticket\Modules\Auth\Dto
 */
final class CredentialsDto extends AbstractionEntity
{
    public string $email;
    public string $password;

    public static function fromState(array $data): self
    {
        return (new self())
            ->setEmail($data['email'])
            ->setPassword($data['password']);
    }

    /**
     * @param string $password
     *
     * @return self
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @param string $email
     *
     * @return self
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
}
