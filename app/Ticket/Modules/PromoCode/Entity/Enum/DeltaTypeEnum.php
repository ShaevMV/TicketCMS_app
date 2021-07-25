<?php

declare(strict_types=1);

namespace App\Ticket\Modules\PromoCode\Entity\Enum;

use BenSampo\Enum\Enum;

/**
 * Class DeltaTypeEnum
 *
 * Класс Enum типов изменения цены в промокоде
 *
 * @package App\Ticket\Modules\PromoCode\Enum
 */
final class DeltaTypeEnum extends Enum
{
    /** @var string Процент */
    public const OPTION_PERCENT = 'Percent';

    /** @var string Фиксированное изменения */
    public const OPTION_SCALAR = 'Scalar';
}
