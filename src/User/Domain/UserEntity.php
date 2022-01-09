<?php

declare(strict_types=1);

namespace Ticket\User\Domain;

use Ticket\Shared\Domain\Entity\AbstractionEntity;
use Webpatser\Uuid\Uuid;

final class UserEntity extends AbstractionEntity
{
    public function __construct(
        protected string $name,
        protected string $email,
        protected string $password,
        protected ?Uuid $id = null,
    ){}

    public static function fromState(array $data): UserEntity
    {
        return new self(
            $data['name'],
            $data['email'],
            bcrypt($data['password']),
            isset($data['id']) ? Uuid::import($data['id']) : null
        );
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function setId(?Uuid $id): self
    {
        $this->id = $id;

        return $this;
    }
}
