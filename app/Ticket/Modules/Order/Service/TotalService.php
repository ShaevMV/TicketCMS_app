<?php

declare(strict_types=1);

namespace App\Ticket\Modules\Order\Service;

use App\Ticket\Modules\Order\Entity\TotalEntity;
use App\Ticket\Modules\TypeRegistration\Entity\TypeRegistration;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Class TotalService
 *
 * Сервис получения стоимости покупки
 *
 * @package App\Ticket\Modules\Order\Service
 */
final class TotalService
{
    /**
     * Фабрика получения стоимости
     *
     * @var TotalFactory
     */
    private TotalFactory $typeOrderFactory;

    /**
     * TotalService constructor.
     *
     * @param TotalFactory $typeOrderFactory
     */
    public function __construct(TotalFactory $typeOrderFactory)
    {
        $this->typeOrderFactory = $typeOrderFactory;
    }

    /**
     * @param TypeRegistration $typeRegistration
     * @param int $count
     * @return TotalEntity
     * @throws BindingResolutionException
     */
    public function getTotal(TypeRegistration $typeRegistration, int $count): TotalEntity
    {
        $total = $this->typeOrderFactory->getTotalStrategy($typeRegistration)
            ->getTotal($typeRegistration->getPrice(), $count);

        return (new TotalEntity())
            ->setCount($count)
            ->setPrice($typeRegistration->getPrice())
            ->setTotal($total);
    }
}
