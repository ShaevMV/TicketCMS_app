<?php

declare(strict_types=1);

namespace App\Ticket\Modules\Festival\Entity;

use App\Ticket\Entity\AbstractionEntityData;
use InvalidArgumentException;

/**
 * Class FestivalStatus
 *
 * Статус у фестиваля
 *
 * @package App\Ticket\Festival\Entity
 */
final class FestivalStatus extends AbstractionEntityData
{
    /**
     * Идентификатор статуса черновик
     *
     * @const int
     */
    public const STATE_DRAFT_ID = 1;

    /**
     * Идентификатор статуса запущенного фестиваля
     *
     * @const int
     */
    public const STATE_PUBLISHED_ID = 2;

    /**
     * Названия статуса черновик
     *
     * @const string
     */
    public const STATE_DRAFT = 'Черновик';

    /**
     * Названия статуса запущенного фестиваля
     *
     * @const string
     */
    public const STATE_PUBLISHED = 'Запущенный фестиваля';

    /**
     * Список статусов
     *
     * @var array
     */
    public const STATE_LIST = [
        self::STATE_DRAFT_ID => self::STATE_DRAFT,
        self::STATE_PUBLISHED_ID => self::STATE_PUBLISHED,
    ];

    /**
     * Идентификатор статуса
     *
     * @var int|null
     */
    protected ?int $id;

    /**
     * Названия статуса
     *
     * @var string|null
     */
    protected ?string $name;

    /**
     * FestivalStatus constructor.
     *
     * @param int $id
     * @param string $name
     */
    private function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * Создать объект по ID статуса
     *
     * @param int $statusId
     *
     * @return self
     *
     * @throws InvalidArgumentException
     */
    public static function fromInt(int $statusId): self
    {
        if (!self::ensureIsValidId($statusId)) {
            throw new InvalidArgumentException('Invalid status id given');
        }

        return new self($statusId, self::STATE_LIST[$statusId]);
    }

    /**
     * Проверка валидности по ID
     *
     * @param int $status
     *
     * @return bool
     */
    private static function ensureIsValidId(int $status): bool
    {
        return array_key_exists($status, self::STATE_LIST);
    }

    /**
     * Создать объект из название
     *
     * @param string $status
     *
     * @return self
     *
     * @throws InvalidArgumentException
     */
    public static function fromString(string $status): self
    {
        if (!self::ensureIsValidName($status)) {
            throw new InvalidArgumentException('Invalid state given!');
        }

        $state = array_search($status, self::STATE_LIST, true);

        return new self((int)$state, $status);
    }

    /**
     * Проверка валидности по названию статуса
     *
     * @param string $status
     *
     * @return bool
     */
    private static function ensureIsValidName(string $status): bool
    {
        return in_array($status, self::STATE_LIST, true);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->id;
    }

    /**
     * Активировать
     *
     * @return void
     */
    public function active(): void
    {
        $this->id = self::STATE_PUBLISHED_ID;
        $this->name = self::STATE_PUBLISHED;
    }

    /**
     * Снять активацию
     */
    public function cancel(): void
    {
        $this->id = self::STATE_DRAFT_ID;
        $this->name = self::STATE_DRAFT;
    }
}
