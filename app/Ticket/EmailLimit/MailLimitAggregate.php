<?php

declare(strict_types=1);

namespace App\Ticket\EmailLimit;

use App\Ticket\EmailLimit\ValueData\LimitValue;
use App\Ticket\EmailLimit\ValueData\MailLimitValue;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Psr\SimpleCache\InvalidArgumentException;

final class MailLimitAggregate
{
    private const KEY_FOR_HOUR_LIMIT_COUNT = 'mail:hour:count';
    private const KEY_FOR_HOUR_LIMIT_TIME = 'mail:hour:time';

    private const KEY_FOR_DAY_LIMIT_COUNT = 'mail:day:count';
    private const KEY_FOR_DAY_LIMIT_TIME = 'mail:day:time';

    private LimitValue $mailLimit;

    public function __construct()
    {
        $this->setMailLimit();
    }

    private function setMailLimit(): void
    {
        $dayCount = (int)Cache::get(self::KEY_FOR_DAY_LIMIT_COUNT, 0);
        $dayTime = Cache::get(self::KEY_FOR_DAY_LIMIT_TIME);

        $hourCount = (int)Cache::get(self::KEY_FOR_HOUR_LIMIT_COUNT, 0);
        $hourTime = Cache::get(self::KEY_FOR_HOUR_LIMIT_TIME);


        $this->mailLimit = new LimitValue(
            MailLimitValue::fromState($dayCount, $dayTime),
            MailLimitValue::fromState($hourCount, $hourTime),
        );
    }

    public function pushMail(): bool
    {
        if ($this->isCheckLimit()) {
            return false;
        }

        $this->incrementLimit();
        $this->setMailLimit();

        return true;
    }

    private function isCheckLimit(): bool
    {
        return $this->mailLimit->isCheckHourLimit() || $this->mailLimit->isCheckDayLimit();
    }

    private function incrementLimit(): void
    {
        if (Cache::get(self::KEY_FOR_HOUR_LIMIT_COUNT) === null) {
            Cache::put(self::KEY_FOR_HOUR_LIMIT_COUNT, 1, Carbon::now()->addMinutes(60));
            Cache::put(self::KEY_FOR_HOUR_LIMIT_TIME, Carbon::now()->addMinutes(60), Carbon::now()->addMinutes(60));
        } else {
            Cache::increment(self::KEY_FOR_HOUR_LIMIT_COUNT, 1);
        }

        if (Cache::get(self::KEY_FOR_DAY_LIMIT_COUNT) === null) {
            Cache::put(self::KEY_FOR_DAY_LIMIT_COUNT, 1, Carbon::now()->addDay());
            Cache::put(self::KEY_FOR_DAY_LIMIT_TIME, Carbon::now()->addDay(), Carbon::now()->addDay());
        } else {
            Cache::increment(self::KEY_FOR_DAY_LIMIT_COUNT, 1);
        }
    }

    /**
     * Вывести время блокировки в минутах
     */
    public function getMinuteLook(): int
    {
        if ($this->mailLimit->isCheckHourLimit()) {
            return $this->mailLimit->getLimitLookHour();
        }

        return $this->mailLimit->getLimitLookDay();
    }

    /**
     * @throws InvalidArgumentException
     */
    public function clear(): void
    {
        Cache::delete(self::KEY_FOR_HOUR_LIMIT_COUNT);
        Cache::delete(self::KEY_FOR_HOUR_LIMIT_TIME);

        Cache::delete(self::KEY_FOR_DAY_LIMIT_COUNT);
        Cache::delete(self::KEY_FOR_DAY_LIMIT_TIME);
    }
}
