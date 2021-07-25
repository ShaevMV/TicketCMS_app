<?php

declare(strict_types=1);

namespace App\Ticket\Filter\Service;

use App\Ticket\Filter\Entity\FilterItem;
use App\Ticket\Filter\Service\Factory\FilterDate;
use App\Ticket\Filter\Service\Factory\FilterDateBetween;
use App\Ticket\Filter\Service\Factory\FilterFieldsAbstract;
use App\Ticket\Filter\Service\Factory\FilterInteger;
use App\Ticket\Filter\Service\Factory\FilterString;
use RuntimeException;

/**
 * Class FilterFactoryService
 *
 * Класс фабрика для получения конкретного фильтра
 *
 * @package App\Ticket\Filter\Service
 */
final class FilterFactoryService
{
    /**
     * Тип фильтра для целого числа
     *
     * @const string
     */
    public const INTEGER_TYPE = 'int';

    /**
     * Тип фильтра для строки
     *
     * @const string
     */
    public const STRING_TYPE = 'string';

    /**
     * Тип фильтра для даты
     *
     * @const string
     */
    public const DATE_TYPE = 'date';

    /**
     * Тип фильтра для промежутка дат
     *
     * @const string
     */
    public const DATE_BETWEEN_TYPE = 'dateBetween';


    /**
     * Инициализация фильтра
     *
     * @param FilterItem $filterItem
     *
     * @return FilterFieldsAbstract
     */
    public static function initFilter(
        FilterItem $filterItem
    ): FilterFieldsAbstract
    {
        switch ($filterItem->getType()) {
            case self::INTEGER_TYPE:
                $result = new FilterInteger($filterItem);
                break;
            case self::STRING_TYPE:
                $result = new FilterString($filterItem);
                break;
            case self::DATE_TYPE:
                $result = new FilterDate($filterItem);
                break;
            case self::DATE_BETWEEN_TYPE:
                $result = new FilterDateBetween($filterItem);
                break;
            default:
                throw new RuntimeException("{$filterItem->getType()} type not found in for type filter");
        }

        return $result;
    }
}
