<?php

namespace Tests\Unit\Model\Service;

use App\Ticket\Model\Model;
use App\Ticket\Model\Service\ModelJoinService;
use App\Ticket\Modules\Festival\Model\FestivalModel;
use BadMethodCallException;
use Database\Seeders\TypeRegistrationSeeder;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionException;
use ReflectionMethod;
use Tests\TestCase;

/**
 * Class ModelServiceTest
 * @package Tests\Unit\Model\Service
 *
 * + Проверить наличие связанной функции
 * + Получить функцию связанной модель
 * + Проверить вызов исключения
 * - Получить связанную модель
 * - Получить выборку из связоной модели
 */
class ModelServiceTest extends TestCase
{
    /** @var ModelJoinService|mixed */
    private $modelService;

    /**
     * Проверить наличие связанной функции
     *
     * @dataProvider getModelProvider
     *
     * @param string $joinTable
     * @param Model $model
     *
     * @return void
     * @throws ReflectionException
     *
     */
    public function testIsCallFunction(string $joinTable, Model $model): void
    {
        $reflectionMethod = new ReflectionMethod($this->modelService, 'isCallFunction');
        $reflectionMethod->setAccessible(true);

        $this->assertTrue($reflectionMethod->invokeArgs($this->modelService, [
            'model' => $model,
            'joinTable' => $joinTable,
        ]));

        $this->assertFalse($reflectionMethod->invokeArgs($this->modelService, [
            'model' => $model,
            'joinTable' => $joinTable . 's',
        ]));
    }

    /**
     * Получить функцию связанной модель без выборки
     * Проверить вызов исключения
     *
     * @dataProvider getModelProvider
     *
     * @param string $joinTable
     * @param Model $model
     * @param callable|null $where
     *
     * @return void
     */
    public function testGetModel(string $joinTable, Model $model, ?callable $where): void
    {
        $this->assertInstanceOf(
            Builder::class,
            $this->modelService->getModel($model, $joinTable, $where)
        );

        $this->assertInstanceOf(
            Collection::class,
            $this->modelService->getModel($model, $joinTable, $where)->get()
        );

        $this->expectException(BadMethodCallException::class);
        $this->modelService->getModel($model, $joinTable . 's', $where);
    }


    /**
     * @return void
     */
    public function testExceptionGetModel(): void
    {
        /** @var MockObject $mockObject */
        $mockObject = $this->createMock(FestivalModel::class);

        /** @var FestivalModel $model */
        $model = clone $mockObject;

        $this->expectException(BadMethodCallException::class);
        (new ModelJoinService())->getModel($model, 'typeRegistration');
    }

    public function getModelProvider(): array
    {
        return [
            [
                'typeRegistration',
                new FestivalModel(),
                function (Builder $builder) {
                    return $builder->where('type_registration_id', '=', TypeRegistrationSeeder::ID_FOR_TEST);
                },
            ],
        ];
    }

    /**
     * @throws BindingResolutionException
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->modelService = $this->app->make(ModelJoinService::class, [
            'model' => new FestivalModel()
        ]);
    }
}
