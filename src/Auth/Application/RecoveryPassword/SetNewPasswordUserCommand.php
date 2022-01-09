<?php

namespace Ticket\Auth\Application\RecoveryPassword;

use Illuminate\Console\Command;
use Ticket\Auth\Domain\RecoveryPassword\DomainExceptionRecoveryPassword;
use Ticket\Auth\Domain\RecoveryPassword\ResponseRecoveryPassword;
use Ticket\Auth\Domain\RecoveryPassword\UserDataForNewPassword;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class SetNewPasswordUserCommand extends Command
{
    protected $signature = 'auth:setNewPassword';

    protected $description = 'Задать новый пароль';

    public function __construct(
        private UserDataForNewPassword $userDataForNewPassword
    )
    {
        parent::__construct();
    }

    /**
     * @throws DomainExceptionRecoveryPassword
     * @throws TokenInvalidException
     */
    public function handle(RecoveryPasswordUser $recoveryPasswordUser): ResponseRecoveryPassword
    {
        return $recoveryPasswordUser->sendNewPassword($this->userDataForNewPassword);
    }
}
