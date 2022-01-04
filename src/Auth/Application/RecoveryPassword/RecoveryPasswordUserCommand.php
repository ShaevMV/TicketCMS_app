<?php

declare(strict_types=1);

namespace Ticket\Auth\Application\RecoveryPassword;

use Illuminate\Console\Command;
use Ticket\Auth\Domain\RecoveryPassword\DomainExceptionRecoveryPassword;
use Ticket\Auth\Domain\RecoveryPassword\ResponseRecoveryPassword;

class RecoveryPasswordUserCommand extends Command
{
    protected $signature = 'auth:recoveryPassword';

    protected $description = 'Восстановление пароля';

    public function __construct(
        private string $email
    ) {
        parent::__construct();
    }

    /**
     * @throws DomainExceptionRecoveryPassword
     */
    public function handle(RecoveryPasswordUser $recoveryPasswordUser): ResponseRecoveryPassword
    {
        return $recoveryPasswordUser->requestRestoration($this->email);
    }
}
