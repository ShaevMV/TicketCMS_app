<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Auth\Service;

use App\Ticket\Modules\Auth\Dto\UserDataForNewPasswordDto;
use App\Ticket\Modules\Auth\Service\UserRecoveryPasswordService;
use Database\Seeders\UserSeeder;
use Tests\TestCase;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

/**
 * + Запросить восстановление пароля
 * - Найти пользователя по email, с проверкой времени жизни hash токена
 * -
 */
class UserRecoveryPasswordServiceTest extends TestCase
{
    private UserRecoveryPasswordService $userRecoveryPasswordService;

    /**
     * Запросить восстановление пароля
     * @throws TokenInvalidException
     */
    public function testRequestRestoration(): string
    {
        $result = $this->userRecoveryPasswordService->requestRestoration(UserSeeder::USER_FOR_TEST);

        self::assertTrue($result->toArray()['success']);

        return $result->getToken();
    }

    /**
     * @throws TokenInvalidException
     * @depends testRequestRestoration
     */
    public function testSendNewPassword(string $token): void
    {
        $request = [
            'token' => $token,
            'email' => UserSeeder::USER_FOR_TEST,
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
