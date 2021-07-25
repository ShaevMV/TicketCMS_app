<?php

namespace Tests\Unit\TypeRegistration\Service;

use App\Ticket\Modules\TypeRegistration\Entity\Parameter;
use App\Ticket\Modules\TypeRegistration\Service\SpecificationService;
use App\Ticket\Modules\TypeRegistration\Specification\SpecificationAnd;
use App\Ticket\Modules\TypeRegistration\Specification\SpecificationCount;
use App\Ticket\Modules\TypeRegistration\Specification\SpecificationEntity;
use Database\Seeders\TypeRegistrationSeeder;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\TestCase;

/**
 * Class TypeRegistrationParameterServiceTest
 *
 * @package Tests\Unit\TypeRegistration\Service
 *
 * + Вывод нужного объекта параметров
 * + Проверка спецификацию для параметров
 * + Проверить список спецификаций по логическому AND
 *
 */
class SpecificationServiceTest extends TestCase
{
    /**
     * @var SpecificationService|mixed
     */
    private $specificationService;

    /**
     * Вывод нужного объекта параметров
     *
     * @dataProvider getParams
     *
     * @param array $data
     * @param object $class
     *
     * @return void
     */
    public function testCreateList(array $data, object $class): void
    {
        $parameter = Parameter::fromState(json_encode($data) ?: null);
        $specificationList = $this->specificationService->createList($parameter);

        $this->assertIsArray($specificationList);
        $this->assertInstanceOf(get_class($class), end($specificationList));
    }

    /**
     * @return array|array[]
     */
    public function getParams(): array
    {
        return [
            [
                TypeRegistrationSeeder::PARAMS_FOR_TEST_COUNT,
                new SpecificationCount(0),
            ],
        ];
    }

    /**
     * @return void
     */
    public function testIsSatisfiedByCount(): void
    {
        $count = TypeRegistrationSeeder::PARAMS_FOR_TEST_COUNT[SpecificationService::KEY_COUNT];
        $specification = new SpecificationCount($count);

        $this->assertTrue(
            $specification->isSatisfiedBy(
                (new SpecificationEntity())
                    ->setCount($count)
            )
        );

        $this->assertFalse(
            $specification->isSatisfiedBy(
                (new SpecificationEntity())
                    ->setCount($count - 1)
            )
        );
    }

    /**
     * Проверить список спецификаций по логическому AND
     *
     * @param array $data
     *
     * @dataProvider getParams
     *
     * @return void
     */
    public function testListAndSpecification(array $data): void
    {
        $parameter = Parameter::fromState(json_encode($data) ?: null);
        $specificationList = $this->specificationService->createList($parameter);
        $specificationAnd = new SpecificationAnd($specificationList);
        $count = TypeRegistrationSeeder::PARAMS_FOR_TEST_COUNT[SpecificationService::KEY_COUNT];

        $this->assertTrue(
            $specificationAnd->isSatisfiedBy(
                (new SpecificationEntity())
                    ->setCount($count)
            )
        );

        $this->assertFalse(
            $specificationAnd->isSatisfiedBy(
                (new SpecificationEntity())
                    ->setCount($count - 1)
            )
        );
    }

    /**
     * @throws BindingResolutionException
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->specificationService = $this->app->make(SpecificationService::class);
    }
}
