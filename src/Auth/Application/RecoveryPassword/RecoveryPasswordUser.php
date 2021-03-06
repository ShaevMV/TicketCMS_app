<?php

declare(strict_types=1);

namespace Ticket\Auth\Application\RecoveryPassword;

use App\Mail\RecoveryPasswordMail;
use Http\Discovery\Exception\NotFoundException;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Ticket\Auth\Domain\RecoveryPassword\DomainExceptionRecoveryPassword;
use Ticket\Auth\Domain\RecoveryPassword\ResponseRecoveryPassword;
use Ticket\Auth\Domain\RecoveryPassword\UserDataForNewPassword;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class RecoveryPasswordUser
{
    private const URL_FOR_RECOVERY_PASSWORD = 'recoveryPassword/';

    /**
     * Отправить запрос на восстановление пароля
     * @throws DomainExceptionRecoveryPassword
     */
    public function requestRestoration(string $email): ResponseRecoveryPassword
    {
        $tokenForRestoration = '';
        $status = Password::sendResetLink([
            'email' => $email
        ], function (CanResetPassword $user, string $token) use (&$tokenForRestoration): void {
            $this->sendPasswordResetNotification($user, $token);
            $tokenForRestoration = $token;
        });
        // TODO: refactoring
        return $this->getResponseByStatus($status)->setToken($tokenForRestoration);
    }

    /**
     * Отправка письма
     *
     * @param CanResetPassword $user
     * @param string $token
     * @return void
     */
    private function sendPasswordResetNotification(CanResetPassword $user, string $token): void
    {
        $url = env('APP_URL') . self::URL_FOR_RECOVERY_PASSWORD . $token;
        Mail::to($user)->send(new RecoveryPasswordMail($url));
    }

    /**
     * Вывести обработку статуса после сброса пароля
     *
     * @throws NotFoundException
     * @throws DomainExceptionRecoveryPassword
     */
    private function getResponseByStatus(string $status): ResponseRecoveryPassword
    {
        switch ($status) {
            case Password::RESET_LINK_SENT:
                return new ResponseRecoveryPassword(
                    true,
                    'На указанную вами почту отправлено письмо для восстановление пароля'
                );
            case Password::PASSWORD_RESET:
                return new ResponseRecoveryPassword(
                    true,
                    'Пароль изменен'
                );
            case Password::INVALID_USER:
                throw new DomainExceptionRecoveryPassword('Такой пользователь не найден');
            case Password::INVALID_TOKEN:
                throw new DomainExceptionRecoveryPassword('Не верная ссылка попробуйте ещё раз');
            case Password::RESET_THROTTLED:
                throw new DomainExceptionRecoveryPassword('Вы уже запросили ссылку, пожалуйста проверти почту. Или свяжитесь с нами');
        }

        throw new DomainExceptionRecoveryPassword('Не известная ошибка ' . $status);
    }

    /**
     * @throws TokenInvalidException
     * @throws DomainExceptionRecoveryPassword
     */
    public function sendNewPassword(UserDataForNewPassword $dataForNewPasswordDto): ResponseRecoveryPassword
    {
        $status = Password::reset(
            $dataForNewPasswordDto->toArray(),
            static function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();
            }
        );

        return $this->getResponseByStatus($status);
    }
}
