<?php

declare(strict_types=1);

namespace App\Ticket\Modules\Auth\Dto;

final class EnvDto
{
    /** @var string Ключ */
    private string $key;

    /** @var string|null Значения ключа */
    private ?string $value = null;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     *
     * @return EnvDto
     */
    public function setKey(string $key): EnvDto
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @param string|null $value
     *
     * @return EnvDto
     */
    public function setValue(?string $value): EnvDto
    {
        $this->value = $value;

        return $this;
    }
}
