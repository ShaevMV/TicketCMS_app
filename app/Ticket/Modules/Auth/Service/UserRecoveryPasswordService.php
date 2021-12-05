<?php

declare(strict_types=1);

namespace App\Ticket\Modules\Auth\Service;

use App\Mail\RecoveryPasswordMail;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use Throwable;

final class UserRecoveryPasswordService
{
    private const URL_FOR_RECOVERY_PASSWORD = 'recoveryPassword/';

    /**
     * Отправить запрос на восстановление пароля
     */
    public function requestRestoration(string $email): bool
    {
        $status = Password::sendResetLink([
            'email' => $email
        ], fn(CanResetPassword $user, string $token) => $this->sendPasswordResetNotification($user, $token));

        return $status === Password::RESET_LINK_SENT;
    }

    private function sendPasswordResetNotification(CanResetPassword $user, string $token): void
    {
        $url = env('APP_URL') . self::URL_FOR_RECOVERY_PASSWORD . $token;

        try {
            Mail::to($user)->send(new RecoveryPasswordMail($url));
        } catch (Throwable $exception) {
            $a = 4;
        }
    }
}
