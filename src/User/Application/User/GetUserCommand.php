<?php

namespace Ticket\User\Application\User;

use Illuminate\Console\Command;
use Ticket\User\Domain\UserAggregate;
use Webpatser\Uuid\Uuid;

class GetUserCommand extends Command
{
    protected $signature = 'user:registration';

    protected $description = 'Регистрация нового пользователя';

    public function __construct(private Uuid $id)
    {
        parent::__construct();
    }

    public function handle(GetUser $getUser): UserAggregate
    {
        return $getUser->get($this->id);
    }

}
