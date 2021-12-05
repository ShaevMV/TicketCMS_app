<?php

declare(strict_types=1);

namespace App\Ticket\Modules\User\Entity;

use App\Ticket\Entity\AbstractionEntity;
use Exception;
use Webpatser\Uuid\Uuid;

class UserEntity extends AbstractionEntity
{
    protected ?Uuid $id = null;
    protected string $name;
    protected string $email;
    protected string $password;

    /**
     * @throws Exception
     */
    public static function fromState(array $data): self
    {
        return (new self())
            ->setId(isset($data['id']) ? Uuid::import($data['id']) : null)
            ->setName($data['name'])
            ->setEmail($data['email'])
            ->setPassword($data['password']);
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function setId(Uuid $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
}
