<?php

declare(strict_types=1);

namespace App\Ticket\Filter\Entity;

use InvalidArgumentException;

/**
 * Class FilterItem
 *
 * Класс для сущности фильтра
 *
 * @package App\Ticket\Filter\Entity
 */
final class FilterItem
{
    public const TYPE_INDEX = "type";
    public const FIELD_INDEX = "index";
    public const VALUE_INDEX = "value";
    public const OPERATION_INDEX = "operation";

    /**
     * Разделитель старки между названием таблицы и полем
     *
     * @const string
     */
    private const DELIMITER = '.';

    /**
     * Оператор для фильтрации по умолчанию
     */
    private const DEFAULT_OPERATION = '=';

    /**
     * Значения для фильтра
     *
     * @var string|array
     */
    private $value;

    /**
     * Поле фильтрации
     *
     * @var string
     */
    private string $field;

    /**
     * Таблица в которой осуществляется поиск
     *
     * @var string
     */
    private string $table;

    /**
     * Тип фильтрации
     *
     * @var string
     */
    private string $type;

    /**
     * Оператор для фильтрации
     *
     * @var string
     */
    private string $operation = self::DEFAULT_OPERATION;

    /**
     * @param array $data
     *
     * @return self
     */
    public static function fromState(array $data): self
    {
        return (new self())
            ->setType($data[self::TYPE_INDEX])
            ->setValue($data[self::VALUE_INDEX])
            ->setOperation($data[self::OPERATION_INDEX] ?? self::DEFAULT_OPERATION)
            ->setFieldAndTable($data[self::FIELD_INDEX]);
    }

    /**
     * Получения данных поля и имени таблицы
     *
     * @param string $field
     *
     * @return FilterItem
     */
    public function setFieldAndTable(string $field): self
    {
        if ($arrFieldAndTable = self::getDelimiter($field)) {
            [$this->table, $this->field] = $arrFieldAndTable;
        } else {
            throw new InvalidArgumentException("{$field} not found DELIMITER '" . self::DELIMITER . "'");
        }

        return $this;
    }

    /**
     * Проверка наличие в старке разделителя
     *
     * @param string $str
     *
     * @return array|bool
     */
    private static function getDelimiter(string $str)
    {
        return strrpos($str, self::DELIMITER) !== false ? explode(self::DELIMITER, $str) : false;
    }

    /**
     * @return string|array
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string|array $value
     *
     * @return $this
     */
    public function setValue($value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @param string $field
     *
     * @return $this
     */
    public function setField(string $field): self
    {
        $this->field = $field;

        return $this;
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return $this
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getOperation(): string
    {
        return $this->operation;
    }

    /**
     * @param string $operation
     *
     * @return $this
     */
    public function setOperation(string $operation = self::DEFAULT_OPERATION): self
    {
        $this->operation = $operation;

        return $this;
    }
}
