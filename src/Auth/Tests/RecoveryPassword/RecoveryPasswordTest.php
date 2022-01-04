<?php

declare(strict_types=1);

namespace Ticket\Auth\Tests\RecoveryPassword;

use Database\Factories\UserFactory;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;
use Ticket\Auth\Application\RecoveryPassword\RecoveryPasswordUser;
use Ticket\Auth\Application\RecoveryPassword\RecoveryPasswordUserCommand;
use Ticket\Auth\Domain\RecoveryPassword\DomainExceptionRecoveryPassword;

class RecoveryPasswordTest extends TestCase
{
    /**
     * @throws DomainExceptionRecoveryPassword
     */
    public function testRequestRestoration(): void
    {
        $result = $this->recoveryPasswordUser->requestRestoration(UserSeeder::USER_LOGIN_FOR_TEST);

        self::assertTrue($result->success);
    }

    public function testCommand(): void
    {
        $result = Bus::dispatchNow(new RecoveryPasswordUserCommand(UserFactory::EMAIL_ADMIN_FOR_TEST));

        self::assertTrue($result->success);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->recoveryPasswordUser = new RecoveryPasswordUser();
    }
}
