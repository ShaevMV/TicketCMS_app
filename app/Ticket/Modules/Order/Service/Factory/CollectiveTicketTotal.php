<?php

declare(strict_types=1);

namespace App\Ticket\Modules\Order\Service\Factory;

use App\Ticket\Modules\TypeRegistration\Entity\Price;

/**
 * Class CollectiveTicketTotal
 *
 * Стоимость коллективного билета
 *
 * @package App\Ticket\Modules\Order\Service\Factory
 */
final class CollectiveTicketTotal implements TotalInterface
{
    /**
     * Получения суммы
     *
     * @param Price $price
     * @param int $count
     *
     * @return Price
     */
    public function getTotal(Price $price, int $count): Price
    {
        return $price;
    }
}
