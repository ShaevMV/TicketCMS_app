<?php

namespace Tests\Unit\Date;

use App\Ticket\Date\DateBetween;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use RuntimeException;

/**
 * Class DateBetweenTest
 *
 * + Создать сущность
 * + Проверить того что даты это даты
 * + Проверить того что начальная дата меньше конечной
 *
 * @package Tests\Unit\Date
 */
class DateBetweenTest extends TestCase
{
    /**
     * Создать начальную и финальную дату
     *
     * @return void
     */
    public function testCreateEntity(): void
    {
        $dateBetween = DateBetween::fromState([
            'date_start' => '2020-06-14',
            'date_end' => '2020-06-15',
        ]);

        self::assertInstanceOf(get_class(new DateBetween()), $dateBetween);
    }

    /**
     * Проверить того что даты это даты
     *
     * @return void
     */
    public function testInvalidArgumentException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        DateBetween::fromState([
            'date_start' => '202-5-14',
            'date_end' => '2020-0-15',
        ]);
    }

    /**
     * Проверить того что начальная дата меньше конечной
     *
     * @return void
     */
    public function testRuntimeException(): void
    {
        $this->expectException(RuntimeException::class);
        DateBetween::fromState([
            'date_start' => '2020-05-14',
            'date_end' => '2020-04-15',
        ]);
    }
}
