<?php

declare(strict_types=1);

namespace App\Ticket\Modules\Order\Service\Factory;

use App\Ticket\Modules\TypeRegistration\Entity\Price;

/**
 * Interface TotalInterface
 *
 * Интерфейс получения суммы
 *
 * @package App\Ticket\Modules\Order\Service\Factory
 */
interface TotalInterface
{
    /**
     * Получения суммы
     *
     * @param Price $price
     * @param int $count
     *
     * @return Price
     */
    public function getTotal(Price $price, int $count): Price;
}
