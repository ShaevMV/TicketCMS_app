<?php

namespace Tests\Unit\Repository;

use App\Ticket\Modules\Festival\Entity\Festival;
use App\Ticket\Modules\Festival\Repository\FestivalRepository;
use App\Ticket\Modules\TypeRegistration\Entity\Price;
use App\Ticket\Modules\TypeRegistration\Repository\TypeRegistrationRepository;
use Database\Seeders\FestivalSeeder;
use Database\Seeders\TypeRegistrationSeeder;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Webpatser\Uuid\Uuid;

/**
 * Class FestivalTest
 *
 * @package Tests\Unit\Repository
 *
 * + Связать проходку с фестивалем
 * + Получить активный фестиваль который проходит сейчас
 */
class FestivalTest extends TestCase
{
    use DatabaseTransactions;

    private string $id;
    private FestivalRepository $festivalRepository;
    private TypeRegistrationRepository $typeRegistrationRepository;

    /**
     * Связать проходку с фестивалем
     *
     * @return void
     */
    public function testJoinTypeRegistrationTable(): void
    {
        $price = (new Price())
            ->setPrice(1000);
        $this->assertTrue($this->festivalRepository->joinTypeRegistration(
            Uuid::import(FestivalSeeder::ID_FOR_TEST),
            Uuid::import(TypeRegistrationSeeder::ID_FOR_TEST),
            $price
        ));
    }

    /**
     * Получить активный фестиваль который проходит сейчас
     *
     * @return void
     * @throws Exception
     *
     */
    public function testGetActive(): void
    {
        /** @var Festival $festival */
        $festival = $this->festivalRepository->getActive();
        $typeRegistrationList = $this->typeRegistrationRepository->getTypeRegistrationForFestival($festival->getId());
        $this->assertIsArray($typeRegistrationList);

        $festival->setTypeRegistration($typeRegistrationList);

        $this->assertInstanceOf(Festival::class, $festival);
    }

    /**
     * @throws BindingResolutionException
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->festivalRepository = $this->app->make(FestivalRepository::class);
        $this->typeRegistrationRepository = $this->app->make(TypeRegistrationRepository::class);
        $this->id = FestivalSeeder::ID_FOR_TEST;
    }
}
