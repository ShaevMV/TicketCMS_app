<?php

declare(strict_types=1);

namespace App\Ticket\Modules\TypeRegistration\DTO;

use App\Ticket\Modules\TypeRegistration\Entity\TypeRegistration;

/**
 * Class TypeRegistrationViewDTO
 *
 * Класс DTO для типов билета
 *
 * @package App\Ticket\Modules\TypeRegistration\DTO
 */
final class TypeRegistrationViewDTO
{
    /**
     * Сущность типа билета
     *
     * @var TypeRegistration
     */
    private TypeRegistration $typeRegistration;

    /**
     * Активность
     *
     * @var bool
     */
    private bool $active;

    /**
     * @return TypeRegistration
     */
    public function getTypeRegistration(): TypeRegistration
    {
        return $this->typeRegistration;
    }

    /**
     * @param TypeRegistration $typeRegistration
     *
     * @return $this
     */
    public function setTypeRegistration(TypeRegistration $typeRegistration): self
    {
        $this->typeRegistration = $typeRegistration;

        return $this;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     *
     * @return $this
     */
    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }
}
