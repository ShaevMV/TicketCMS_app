<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Auth\Service;

use App\Ticket\Modules\Auth\Service\UserRecoveryPasswordService;
use Database\Seeders\UserSeeder;
use Tests\TestCase;

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
     */
    public function testRequestRestoration(): void
    {
        $result = $this->userRecoveryPasswordService->requestRestoration(UserSeeder::USER_FOR_TEST);

        self::assertTrue($result);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRecoveryPasswordService = $this->app->make(UserRecoveryPasswordService::class);
    }
}
