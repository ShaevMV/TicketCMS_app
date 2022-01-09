<?php

namespace Ticket\User\Application\Registration;

use Illuminate\Console\Command;
use Ticket\User\Domain\UserAggregate;
use Ticket\User\Domain\UserEntity;

class RegistrationUserCommand extends Command
{
    protected $signature = 'user:registration';

    protected $description = 'Регистрация нового пользователя';

    public function __construct(private UserEntity $userEntity)
    {
        parent::__construct();
    }

    public function handle(RegistrationUser $registrationUser): UserAggregate
    {
        return $registrationUser->createNewUser($this->userEntity);
    }
}
