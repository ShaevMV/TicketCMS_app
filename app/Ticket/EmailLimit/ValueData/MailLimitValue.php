<?php

namespace App\Ticket\EmailLimit\ValueData;

use Illuminate\Support\Carbon;

final class MailLimitValue
{
    public int $count;
    public Carbon $ttl;

    public function __construct(int $limitCount, Carbon $limitTime)
    {
        $this->count = $limitCount;
        $this->ttl = $limitTime;
    }

    public static function fromState(int $limitCount, ?Carbon $limitTime): self
    {
        return new self($limitCount, $limitTime ?? now());
    }
}
