<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Auth\Service;

use App\Ticket\Modules\Auth\Dto\UserDataForNewPasswordDto;
use App\Ticket\Modules\Auth\Exception\DomainExceptionRecoveryPassword;
use App\Ticket\Modules\Auth\Service\UserRecoveryPasswordService;
use Database\Seeders\UserSeeder;
use Tests\TestCase;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

/**
 * + Запросить восстановление пароля.
 * + Записать новый пароль пользователя
 */
class UserRecoveryPasswordServiceTest extends TestCase
{
    private UserRecoveryPasswordService $userRecoveryPasswordService;

    /**
     * Запросить восстановление пароля
     *
     * @throws DomainExceptionRecoveryPassword
     */
    public function testRequestRestoration(): string
    {
        $result = $this->userRecoveryPasswordService->requestRestoration(UserSeeder::USER_LOGIN_FOR_TEST);

        self::assertTrue($result->toArray()['success']);

        return $result->getToken();
    }

    /**
     * Записать новый пароль пользователя
     * @param string $token
     * @throws DomainExceptionRecoveryPassword
     * @throws TokenInvalidException
     * @depends testRequestRestoration
     */
    public function testSendNewPassword(string $token): void
    {
        $request = [
            'token' => $token,
            'email' => UserSeeder::USER_LOGIN_FOR_TEST,
            'password' => 'systempass12',
            'password_confirmation' => 'systempass12',
        ];
        $result = $this->userRecoveryPasswordService->sendNewPassword(UserDataForNewPasswordDto::fromState($request));
        self::assertTrue($result->toArray()['success']);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRecoveryPasswordService = $this->app->make(UserRecoveryPasswordService::class);
    }
}
