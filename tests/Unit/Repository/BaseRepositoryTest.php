<?php

namespace Tests\Unit\Repository;

use App\Ticket\Date\DateBetween;
use App\Ticket\Entity\EntityInterface;
use App\Ticket\Modules\Festival\Entity\Festival;
use App\Ticket\Modules\Festival\Entity\FestivalStatus;
use App\Ticket\Modules\Festival\Model\FestivalModel;
use App\Ticket\Modules\Festival\Repository\FestivalRepository;
use App\Ticket\Modules\PromoCode\Entity\DeltaPrice;
use App\Ticket\Modules\PromoCode\Entity\Enum\DeltaTypeEnum;
use App\Ticket\Modules\PromoCode\Entity\PromoCode;
use App\Ticket\Modules\PromoCode\Model\PromoCodeModel;
use App\Ticket\Modules\PromoCode\Repository\PromoCodeRepository;
use App\Ticket\Modules\TypeRegistration\Entity\TypeRegistration;
use App\Ticket\Modules\TypeRegistration\Model\TypeRegistrationModule;
use App\Ticket\Modules\TypeRegistration\Repository\TypeRegistrationRepository;
use App\Ticket\Repository\RepositoryInterface;
use Carbon\Carbon;
use Database\Seeders\FestivalSeeder;
use Database\Seeders\PromoCodeSeeder;
use Database\Seeders\TypeRegistrationSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Webpatser\Uuid\Uuid;

/**
 * Class BaseRepositoryTest
 *
 * + Создания записи
 * + Чтения записи
 * + Обновления записи
 * + Удаление
 *
 * @package Tests\Unit\Repository
 */
class BaseRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Создания записи
     *
     * @dataProvider dataProviderRepository
     *
     * @param EntityInterface $entity
     * @param RepositoryInterface $repository
     *
     * @return void
     */
    public function testCreate(EntityInterface $entity, RepositoryInterface $repository): void
    {
        self::assertInstanceOf(Uuid::class, $repository->create($entity));
    }

    /**
     * Обновления записи
     *
     * @dataProvider dataProviderRepository
     *
     * @param EntityInterface $entity
     * @param RepositoryInterface $repository
     *
     * @return void
     */
    public function testUpdate(EntityInterface $entity, RepositoryInterface $repository): void
    {
        self::assertTrue($repository->update($entity->id, $entity));
    }

    /**
     * Обновления записи
     *
     * @dataProvider dataProviderRepository
     *
     * @param EntityInterface $entity
     * @param RepositoryInterface $repository
     *
     * @return void
     */
    public function testRemove(EntityInterface $entity, RepositoryInterface $repository): void
    {
        self::assertTrue($repository->remove($entity->id));
    }

    /**
     * Чтения записи
     *
     * @dataProvider dataProviderRepository
     *
     * @param EntityInterface $entity
     * @param RepositoryInterface $repository
     *
     * @return void
     */
    public function testRead(EntityInterface $entity, RepositoryInterface $repository): void
    {
        self::assertInstanceOf(EntityInterface::class, $repository->findById($entity->id));
    }

    public function dataProviderRepository(): array
    {
        return [
            // Festivals
            [
                (new Festival())
                    ->setId(Uuid::import(FestivalSeeder::ID_FOR_TEST))
                    ->setTitle("Test")
                    ->setDate(DateBetween::fromState([
                        'date_start' => Carbon::today()->toDateString(),
                        'date_end' => Carbon::today()->addDay()->toDateString(),
                    ]))
                    ->setDescription("TestDescription")
                    ->setStatus(FestivalStatus::fromString(FestivalStatus::STATE_PUBLISHED)),
                new FestivalRepository(new FestivalModel())
            ],
            //TypeRegistration
            [
                (new TypeRegistration())
                    ->setId(Uuid::import(TypeRegistrationSeeder::ID_FOR_TEST))
                    ->setTitle("Test"),
                new TypeRegistrationRepository(new TypeRegistrationModule())
            ],
            // Promo Code
            [
                (new PromoCode())
                    ->setName('Test')
                    ->setId(Uuid::import(PromoCodeSeeder::ID_FOR_TEST_SCALAR))
                    ->setFestivalId(Uuid::import(FestivalSeeder::ID_FOR_TEST))
                    ->setDate(DateBetween::fromState([
                        'date_start' => Carbon::today()->toDateString(),
                        'date_end' => Carbon::today()->addDay()->toDateString(),
                    ]))
                    ->setDelta(DeltaPrice::fromState([
                        'delta_type' => DeltaTypeEnum::OPTION_PERCENT,
                        'delta_price' => 10,
                    ]))
                    ->setActive(true),
                new PromoCodeRepository(new PromoCodeModel())
            ],
        ];
    }
}
