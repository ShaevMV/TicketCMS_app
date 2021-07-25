<?php

declare(strict_types=1);

namespace App\Ticket\Modules\User\Entity;

use App\Ticket\Entity\AbstractionEntity;
use Exception;
use Webpatser\Uuid\Uuid;

class UserEntity extends AbstractionEntity
{
    protected Uuid $id;
    protected string $name;
    protected string $email;
    protected string $password;

    /**
     * @param array $data
     *
     * @return self
     *
     * @throws Exception
     */
    public static function fromState(array $data): self
    {
        return (new self())
            ->setId(isset($data['id']) ? Uuid::import($data['id']) : Uuid::generate())
            ->setName($data['name'])
            ->setEmail($data['email'])
            ->setPassword($data['password']);
    }

    /**
     * @return Uuid
     */
    public function getId(): Uuid
    {
        return $this->id;
    }

    /**
     * @param Uuid $id
     *
     * @return self
     */
    public function setId(Uuid $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
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

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
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
}
