<?php

declare(strict_types=1);

namespace Ticket\Shared\Domain\Model\Service;


use BadMethodCallException;
use Closure;
use ErrorException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use RuntimeException;
use Ticket\Shared\Domain\Model\Exceptions\ModelException;
use Ticket\Shared\Domain\Model\Model;

/**
 * Class ModelService
 *
 * Сервис для связи модели
 *
 * @package App\Ticket\Model\Service
 */
final class ModelJoinService
{
    /**
     * Получить связанную модель
     *
     * @param Model $model
     * @param string $joinModel
     * @param Closure|null $where
     *
     * @return Builder
     */
    public function getModel(Model $model, string $joinModel, ?Closure $where = null): Builder
    {
        if (!$this->isCallFunction($model, $joinModel)) {
            throw new BadMethodCallException("Function {$joinModel} not found in {$model->getMorphClass()}");
        }

        return $this->getCall($model, $joinModel, $where ?? null);
    }

    /**
     * Проверить наличие функции в классе модели
     *
     * @param Model $model
     * @param string $joinTable
     *
     * @return bool
     */
    private function isCallFunction(Model $model, string $joinTable): bool
    {
        return method_exists($model, $joinTable);
    }

    /**
     * Выполнить фильтрацию в базе данных
     *
     * @param Model $model
     * @param string $joinTable
     * @param Closure|null $where
     *
     * @return Builder
     */
    private function getCall(Model $model, string $joinTable, ?Closure $where): Builder
    {
        try {
            return match (get_class($model->$joinTable())) {
                BelongsToMany::class => $model->whereHas(
                    $joinTable,
                    function (Builder $builder) use ($where) {
                        if (null === $where) {
                            throw new ModelException("Значения параметра $where не должно быть пустым");
                        }

                        $where($builder);
                    }
                ),
                default => throw new ErrorException("Type function {$joinTable} not correct"),
            };
        } catch (ErrorException $exception) {
            throw new BadMethodCallException(
                "Bad value method {$joinTable} in class " . get_class($model) . " {$exception->getMessage()}"
            );
        }
    }
}
