<?php

namespace Tests\Unit\Repository;

use App\Ticket\Modules\TypeRegistration\Entity\TypeRegistration;
use App\Ticket\Modules\TypeRegistration\Repository\TypeRegistrationRepository;
use Database\Seeders\FestivalSeeder;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Webpatser\Uuid\Uuid;

/**
 * Class TypeRegistrationTest
 * @package Tests\Unit\Repository
 *
 * + Вывести все типы проходок в фестивале
 */
class TypeRegistrationTest extends TestCase
{
    use DatabaseTransactions;

    protected $typeRegistrationRepository;

    /**
     * Вывести все типы проходок в фестивале
     */
    public function testGetAllTypeRegistration(): void
    {
        $listTypeRegistration = $this->typeRegistrationRepository
            ->getTypeRegistrationForFestival(Uuid::import(FestivalSeeder::ID_FOR_TEST));

        self::assertIsArray($listTypeRegistration);
        self::assertCount(2, $listTypeRegistration);
        self::assertInstanceOf(TypeRegistration::class, end($listTypeRegistration));
    }

    /**
     * @throws BindingResolutionException
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->typeRegistrationRepository = $this->app->make(TypeRegistrationRepository::class);
    }
}
