<?php

namespace Ticket\User\Application\User;

use DomainException;
use Illuminate\Console\Command;
use Ticket\User\Domain\UserAggregate;
use Ticket\User\Domain\UserLocatorData;

class GetUserCommand extends Command
{
    protected $signature = 'user:registration';

    protected $description = 'Регистрация нового пользователя';

    public function __construct(private UserLocatorData $userLocatorData)
    {
        parent::__construct();
    }

    public function handle(GetUser $getUser): UserAggregate
    {
        if ($this->userLocatorData->getUuid() !== null) {
            return $getUser->findById($this->userLocatorData->getUuid());
        }

        throw new DomainException('Не введены данные для нахождения пользователя');
    }
}
