<?php

declare(strict_types=1);

namespace App\Ticket\Modules\Auth\Entity;

use App\Ticket\Entity\AbstractionEntity;

/**
 * Class AccessToken
 *
 * @package App\Ticket\Modules\Auth\Entity
 */
final class AccessToken extends AbstractionEntity
{
    /** @var string  Ключ клиента */
    protected string $passwordKey;

    /** @var string  Идентификатор клиента */
    protected string $clientId;

    /**
     * @param array $data
     * @return AccessToken
     */
    public static function fromState(array $data)
    {
        return (new self())
            ->setClientId($data['id'])
            ->setPasswordKey($data['secret']);
    }

    /**
     * @return string
     */
    public function getPasswordKey(): string
    {
        return $this->passwordKey;
    }

    /**
     * @param string $passwordKey
     * @return AccessToken
     */
    public function setPasswordKey(string $passwordKey): AccessToken
    {
        $this->passwordKey = $passwordKey;

        return $this;
    }

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->clientId;
    }

    /**
     * @param string $clientId
     * @return AccessToken
     */
    public function setClientId(string $clientId): AccessToken
    {
        $this->clientId = $clientId;
        return $this;
    }

    protected function getColumnsList(): array
    {
        return [];
    }
}
