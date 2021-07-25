<?php

declare(strict_types=1);

namespace App\Ticket\Modules\Order\Service;

use App\Ticket\Modules\Order\Service\Factory\CollectiveTicketTotal;
use App\Ticket\Modules\Order\Service\Factory\DefaultTotal;
use App\Ticket\Modules\Order\Service\Factory\TotalInterface;
use App\Ticket\Modules\TypeRegistration\Entity\TypeRegistration;
use App\Ticket\Modules\TypeRegistration\Service\SpecificationService;
use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Class TotalFactory
 *
 * Фабрика получения стратегии стоимости
 *
 * @package App\Ticket\Modules\Order\Service
 */
final class TotalFactory
{
    /**
     * DI
     *
     * @var Container
     */
    private Container $container;

    /**
     * TotalFactory constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Получения стратегии для получения стоимости
     *
     * @param TypeRegistration $typeRegistration
     *
     * @return TotalInterface
     * @throws BindingResolutionException
     *
     */
    public function getTotalStrategy(TypeRegistration $typeRegistration): TotalInterface
    {
        $params = $typeRegistration->getParams();

        if ($params !== null && array_key_exists(SpecificationService::KEY_COUNT, $params->toArray())) {
            return $this->container->make(CollectiveTicketTotal::class);
        }

        return new DefaultTotal();
    }
}
