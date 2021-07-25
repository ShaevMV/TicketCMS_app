<?php

namespace Tests\Unit\TypeRegistration\Service;

use App\Ticket\Modules\TypeRegistration\DTO\TypeRegistrationViewDTO;
use App\Ticket\Modules\TypeRegistration\Repository\TypeRegistrationRepository;
use App\Ticket\Modules\TypeRegistration\Service\SpecificationService;
use App\Ticket\Modules\TypeRegistration\Service\TypeRegistrationListService;
use App\Ticket\Modules\TypeRegistration\Specification\SpecificationEntity;
use Database\Seeders\FestivalSeeder;
use Database\Seeders\TypeRegistrationSeeder;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\TestCase;
use Webpatser\Uuid\Uuid;

/**
 * Class TypeRegistrationServiceTest
 *
 * @package Tests\Unit\TypeRegistration\Service
 *
 * + Вывести список TypeRegistrationDTO
 */
class TypeRegistrationServiceTest extends TestCase
{
    /** @var TypeRegistrationListService|mixed */
    private $typeRegistrationListService;

    /** @var TypeRegistrationRepository|mixed */
    private $typeRegistrationRepository;

    /**
     * Вывести список TypeRegistrationDTO
     *
     * @dataProvider getSpecification
     *
     * @param Uuid $festivalId
     * @param SpecificationEntity $specificationEntity
     *
     * @return void
     */
    public function testGetList(Uuid $festivalId, SpecificationEntity $specificationEntity): void
    {
        $typeRegistrationList = $this->typeRegistrationRepository
            ->getTypeRegistrationForFestival($festivalId);
        $typeRegistrationDTO = $this->typeRegistrationListService->getList($typeRegistrationList, $specificationEntity);

        $this->assertIsArray($typeRegistrationDTO);
        $this->assertInstanceOf(TypeRegistrationViewDTO::class, end($typeRegistrationDTO));

        $this->assertTrue($typeRegistrationDTO[0]->isActive());
        $this->assertFalse(end($typeRegistrationDTO)->isActive());
    }

    public function getSpecification(): array
    {
        return [
            [
                Uuid::import(FestivalSeeder::ID_FOR_TEST),
                (new SpecificationEntity())
                    ->setCount(TypeRegistrationSeeder::PARAMS_FOR_TEST_COUNT[SpecificationService::KEY_COUNT] - 1)
            ],
        ];
    }

    /**
     * @throws BindingResolutionException
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->typeRegistrationListService = $this->app->make(TypeRegistrationListService::class);
        $this->typeRegistrationRepository = $this->app->make(TypeRegistrationRepository::class);
    }
}
