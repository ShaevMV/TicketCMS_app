<?php

declare(strict_types=1);

namespace App\Ticket\Modules\TypeRegistration\Service;

use App\Ticket\Modules\TypeRegistration\Entity\Price;
use App\Ticket\Modules\TypeRegistration\Entity\TypeRegistration;

/**
 * Class TotalService
 *
 * Сервис для получения конечной цены за билет
 *
 * @package App\Ticket\Modules\TypeRegistration\Service
 */
final class TotalService
{
    /**
     * Вывести цену
     *
     * @param TypeRegistration $typeRegistration
     * @param int $count
     *
     * @return Price
     */
    public function getPrice(TypeRegistration $typeRegistration, int $count = 1): Price
    {
        return Price::fromState($typeRegistration->getPrice()->getInt() * $count);
    }
}
