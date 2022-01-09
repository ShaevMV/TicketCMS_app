<?php

declare(strict_types=1);

namespace Ticket\Auth\Tests\RecoveryPassword;

use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;
use Ticket\Auth\Application\RecoveryPassword\RecoveryPasswordUser;
use Ticket\Auth\Application\RecoveryPassword\SetNewPasswordUserCommand;
use Ticket\Auth\Domain\RecoveryPassword\DomainExceptionRecoveryPassword;
use Ticket\Auth\Domain\RecoveryPassword\UserDataForNewPassword;

class SetNewPasswordTest extends TestCase
{
    use DatabaseTransactions;

    private RecoveryPasswordUser $recoveryPasswordUser;

    /**
     * @throws DomainExceptionRecoveryPassword
     */
    public function testSendNewPassword(): void
    {
        $token = $this->recoveryPasswordUser->requestRestoration(UserSeeder::USER_LOGIN_FOR_TEST)->getToken();
        $userDataForNewPassword = new UserDataForNewPassword(
            $token,
            UserSeeder::USER_LOGIN_FOR_TEST,
            'test',
            'test'
        );

        $result = Bus::dispatchNow(new SetNewPasswordUserCommand($userDataForNewPassword));
        self::assertTrue($result->success);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->recoveryPasswordUser = new RecoveryPasswordUser();
    }
}
