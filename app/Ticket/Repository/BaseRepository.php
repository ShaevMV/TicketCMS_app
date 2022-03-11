<?php

declare(strict_types=1);

namespace App\Ticket\Repository;

use App\Ticket\Entity\EntityInterface;
use App\Ticket\Entity\EntityService;
use App\Ticket\Filter\FilterList;
use App\Ticket\Model\Model;
use App\Ticket\Pagination\Pagination;
use App\Ticket\Repository\Exceptions\RepositoryRuntimeException;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as BuilderQuery;
use Illuminate\Support\Facades\DB;
use OutOfBoundsException;
use Throwable;
use Webpatser\Uuid\Uuid;

/**
 * Базовый класс репозитория
 */
abstract class BaseRepository implements RepositoryInterface
{
    /**
     * Модель в базе данных
     *
     * @var Model
     */
    protected $model;

    /**
     * Builder для работы с базой данных
     *
     * @var Builder|BuilderQuery
     */
    protected $builder;

    /**
     * Обновить данные
     *
     * @throws Exception
     * @throws Throwable
     */
    public function update(Uuid $id, EntityInterface $data): bool
    {
        DB::beginTransaction();
        try {
            if ($this->model::whereId((string)$id)->exists() === false) {
                throw new OutOfBoundsException(self::class . ' with id ' . $id . ' does not exist');
            }

            $update = EntityService::getNotEmptyFields($data);

            if ($this->model
                    ::where('id', '=', (string)$id)
                    ->update($update) > 0) {
                DB::commit();

                return true;
            }

            throw new RepositoryRuntimeException($this->model->getTable() . ' не получилось обновить ' . $id);
        } catch (Exception $exception) {
            DB::rollBack();

            throw $exception;
        }
    }

    /**
     * Выполнить пагинацию в модели
     *
     * @param Pagination|null $pagination
     *
     * @return $this
     */
    public function setPagination(?Pagination &$pagination = null): self
    {
        if ($pagination !== null) {
            $builder = $this->getBuilder();
            $pagination->setTotal($this->getTotal());
            $builder->forPage($pagination->getPage(), $pagination->getLimit());
            $this->setBuilder($builder);
        }

        return $this;
    }

    /**
     * @return Builder|BuilderQuery
     */
    public function getBuilder()
    {
        if (null === $this->builder) {
            $this->builder = $this->model::getQuery();
        }

        return $this->builder;
    }

    /**
     * @param Builder|BuilderQuery $builder
     */
    public function setBuilder($builder): void
    {
        $this->builder = $builder;
    }

    /**
     * Вывести общее кол-во записей
     */
    public function getTotal(): int
    {
        return $this->getBuilder()->get()->count();
    }

    /**
     * Выполнить фильтрацию в модели
     */
    public function setFilter(?FilterList $fields): self
    {
        if ($fields !== null && $builder = $fields->filtration($this->getBuilder(), $this->model)) {
            $this->setBuilder($builder);
        }

        return $this;
    }

    /**
     * @return EntityInterface[]|null
     */
    public function getList(): ?array
    {
        $result = [];
        foreach ($this->getBuilder()->get() as $item) {
            $result[] = $this->build((array)$item);
        }

        return empty($result) ? null : $result;
    }

    /**
     * Выдать сущность
     */
    abstract protected function build(array $data): EntityInterface;

    /**
     * @throws Exception | RepositoryRuntimeException|Throwable
     */
    public function create(EntityInterface $entity): Uuid
    {
        DB::beginTransaction();
        try {
            $data = $entity->toArray();
            if (null === $data) {
                throw new RepositoryRuntimeException("Entity is null");
            }

            $create = $this->model::create($data);
            if (!isset($create->id)) {
                throw new RepositoryRuntimeException("В таблице {$this->model->getTable()} не удалось создать запись");
            }
            //DB::commit();
        } catch (Exception $exception) {
            DB::rollback();
            throw $exception;
        }

        return Uuid::import($create->id);
    }

    /**
     * Найти по id
     */
    public function findById(Uuid $id): EntityInterface
    {
        try {
            $arrayData = $this->model::findorfail((string)$id);
        } catch (OutOfBoundsException $e) {
            throw new OutOfBoundsException($this->model->getTable() . ' with id ' . $id . ' does not exist');
        }

        return $this->build($arrayData->toArray());
    }

    /**
     * Удаление записи
     *
     * @throws Exception
     */
    public function remove(Uuid $id): bool
    {
        DB::beginTransaction();
        try {
            if ($this->model::destroy((string)$id) > 0) {
                DB::commit();
            }

            throw new RepositoryRuntimeException("В таблице {$this->model->getTable()} не удалось удалить запись " . $id);
        } catch (Exception $exception) {
            DB::rollback();

            throw $exception;
        }
    }
}
