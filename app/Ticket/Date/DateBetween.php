<?php

declare(strict_types=1);

namespace App\Ticket\Date;

use App\Ticket\Entity\AbstractionEntity;
use Carbon\Carbon;
use Exception;
use InvalidArgumentException;
use RuntimeException;

/**
 * Class DateBetween
 *
 * Класс для работы с промежутком дат
 *
 * @package App\Ticket\Date
 */
final class DateBetween extends AbstractionEntity
{
    private const COLUMNS_LIST = [
        'date_start' => [
            'value' => 'Дата начала',
            'type' => self::TYPE_DATE,
        ],
        'date_end' => [
            'value' => 'Дата окончание',
            'type' => self::TYPE_DATE,
        ],
    ];

    /**
     * Начальная дата
     *
     * @var Carbon
     */
    protected Carbon $date_start;

    /**
     * Дата окончания
     *
     * @var Carbon
     */
    protected Carbon $date_end;

    /**
     * Получить сущность из массива
     *
     * @param array $data
     *
     * @return self
     */
    public static function fromState(array $data): self
    {
        $dateCarbonStart = self::fromStateDate($data['date_start']);
        $dateCarbonEnd = self::fromStateDate($data['date_end']);

        if ($dateCarbonEnd < $dateCarbonStart) {
            throw new RuntimeException('Start date is greater than end date');
        }

        return (new self())
            ->setDateStart($dateCarbonStart)
            ->setDateEnd($dateCarbonEnd);
    }

    /**
     * Перевести дату в Carbon
     *
     * @param string $date
     *
     * @return Carbon
     * @throws InvalidArgumentException
     *
     */
    private static function fromStateDate(string $date): Carbon
    {
        try {
            $dateCarbon = new Carbon($date);

            if ((string)$dateCarbon->format('Y-m-d') !== $date) {
                throw new Exception('Date not correct value');
            }
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $dateCarbon;
    }

    /**
     * @return Carbon
     */
    public function getDateStart(): Carbon
    {
        return $this->date_start;
    }

    /**
     * @param Carbon $date_start
     *
     * @return DateBetween
     */
    public function setDateStart(Carbon $date_start): DateBetween
    {
        $this->date_start = $date_start;

        return $this;
    }

    /**
     * @return Carbon
     */
    public function getDateEnd(): Carbon
    {
        return $this->date_end;
    }

    /**
     * @param Carbon $date_end
     *
     * @return DateBetween
     */
    public function setDateEnd(Carbon $date_end): DateBetween
    {
        $this->date_end = $date_end;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function getColumnsList(): array
    {
        return self::COLUMNS_LIST;
    }
}
