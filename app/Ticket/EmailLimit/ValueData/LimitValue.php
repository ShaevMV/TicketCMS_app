<?php

declare(strict_types=1);

namespace App\Ticket\EmailLimit\ValueData;

final class LimitValue
{
    private const MAIL_LIMIT_HOUR = 100;
    private const MAIL_LIMIT_DAY = 300;

    private MailLimitValue $limitHour;
    private MailLimitValue $limitDay;

    public function __construct(
        MailLimitValue $limitDay,
        MailLimitValue $limitHour
    )
    {
        $this->limitDay = $limitDay;
        $this->limitHour = $limitHour;
    }

    /**
     * Проверить часовой лимит отправки почты
     */
    public function isCheckHourLimit(): bool
    {
        return $this->limitHour->count > self::MAIL_LIMIT_HOUR;
    }

    /**
     * Проверить дневной лимит отправки почты
     */
    public function isCheckDayLimit(): bool
    {
        return $this->limitDay->count > self::MAIL_LIMIT_DAY;
    }

    public function getLimitLookHour(): int
    {
        return now()->diffInMinutes($this->limitHour->ttl);
    }

    public function getLimitLookDay(): int
    {
        return now()->diffInMinutes($this->limitDay->ttl);
    }
}
