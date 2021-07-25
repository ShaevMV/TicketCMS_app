<?php

declare(strict_types=1);

namespace App\Ticket\Repository;

use App\Ticket\Entity\EntityInterface;
use Webpatser\Uuid\Uuid;

/**
 * Interface RepositoryInterface
 *
 * Интерфейс для репозитория
 *
 * @package App\Ticket\Repository
 */
interface RepositoryInterface
{
    /**
     * Сохранить данные в базу
     *
     * @param EntityInterface $entity
     *
     * @return Uuid|null
     */
    public function create(EntityInterface $entity): ?Uuid;

    /**
     * Вывести список entity
     *
     * @return EntityInterface[]|null
     */
    public function getList(): ?array;

    /**
     * Обновить данные в модели
     *
     * @param Uuid $id
     * @param EntityInterface $data
     *
     * @return bool
     */
    public function update(Uuid $id, EntityInterface $data): bool;

    /**
     * Найти запись в базе по его id
     *
     * @param Uuid $id
     *
     * @return mixed
     */
    public function findById(Uuid $id);

    /**
     * Удаление записи
     *
     * @param Uuid $id
     *
     * @return bool
     */
    public function remove(Uuid $id): bool;

    public function getTotal(): int;
}
