<?php

namespace Tests\Unit\EmailLimit;

use App\Ticket\EmailLimit\MailLimitAggregate;
use Psr\SimpleCache\InvalidArgumentException;
use Tests\TestCase;

class MailLimitAggregateTest extends TestCase
{
    private MailLimitAggregate $mailLimitAggregate;

    /**
     * @throws InvalidArgumentException
     */
    public function testPushMail(): void
    {
        $this->mailLimitAggregate->clear();
        self::assertTrue($this->mailLimitAggregate->pushMail());
        $this->mailLimitAggregate->clear();
    }

    /**
     * @throws InvalidArgumentException
     */
    public function testGetTime(): void
    {
        do {
            $this->mailLimitAggregate->pushMail();
        } while ($this->mailLimitAggregate->pushMail());
        self::assertFalse($this->mailLimitAggregate->pushMail());
        self::assertNotSame(50, $this->mailLimitAggregate->getMinuteLook());
        $this->mailLimitAggregate->clear();
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->mailLimitAggregate = $this->app->make(MailLimitAggregate::class);
    }
}
