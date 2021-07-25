<?php

namespace Tests\Unit\Order\Service;

use App\Ticket\Modules\Order\Entity\TotalEntity;
use App\Ticket\Modules\Order\Service\Factory\CollectiveTicketTotal;
use App\Ticket\Modules\Order\Service\Factory\DefaultTotal;
use App\Ticket\Modules\Order\Service\TotalFactory;
use App\Ticket\Modules\Order\Service\TotalService;
use App\Ticket\Modules\TypeRegistration\Entity\Parameter;
use App\Ticket\Modules\TypeRegistration\Entity\Price;
use App\Ticket\Modules\TypeRegistration\Entity\TypeRegistration;
use Database\Seeders\TypeRegistrationSeeder;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\TestCase;

/**
 * Class TotalServiceTest
 *
 * + Получение цены
 *
 * @package Tests\Unit\Order\Service
 */
class TotalServiceTest extends TestCase
{
    /** @var TotalService|mixed */
    private $totalService;

    /** @var TotalFactory|mixed */
    private $totalFactoryStrategy;

    /**
     * @dataProvider typeRegistrationProvider
     *
     * @param TypeRegistration $typeRegistration
     * @param object $class
     * @param TotalEntity $totalEntity
     *
     * @return void
     * @throws BindingResolutionException
     *
     */
    public function testGetTotal(TypeRegistration $typeRegistration, object $class, TotalEntity $totalEntity): void
    {
        $this->assertEquals($this->totalService->getTotal($typeRegistration, $totalEntity->getCount()), $totalEntity);
        $this->assertInstanceOf(get_class($class), $this->totalFactoryStrategy->getTotalStrategy($typeRegistration));
    }

    /**
     * @return array[]
     */
    public function typeRegistrationProvider(): array
    {
        return [
            [
                (new TypeRegistration())
                    ->setParams(null)
                    ->setPrice(Price::fromState(1000)),
                new DefaultTotal(),
                TotalEntity::fromSate(
                    Price::fromState(1000),
                    3,
                    Price::fromState(3000)
                ),
            ],
            [
                (new TypeRegistration())
                    ->setPrice(Price::fromState(1000))
                    ->setParams(Parameter::fromState(
                        json_encode(TypeRegistrationSeeder::PARAMS_FOR_TEST_COUNT) ?: null
                    )),
                new CollectiveTicketTotal(),
                TotalEntity::fromSate(
                    Price::fromState(1000),
                    3,
                    Price::fromState(1000)
                )
            ]
        ];
    }

    /**
     * @throws BindingResolutionException
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->totalService = $this->app->make(TotalService::class);
        $this->totalFactoryStrategy = $this->app->make(TotalFactory::class);
    }
}
