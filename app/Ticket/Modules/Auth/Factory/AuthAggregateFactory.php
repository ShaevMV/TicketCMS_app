<?php

declare(strict_types=1);

namespace App\Ticket\Modules\Auth\Factory;

use App;
use App\Ticket\Modules\Auth\Aggregate\AuthAggregate;
use App\Ticket\Modules\Auth\Entity\CredentialsDto;

class AuthAggregateFactory
{
    public static function getAggregate(?CredentialsDto $credentialsDto = null): AuthAggregate
    {
        return App::make(AuthAggregate::class, [
            'credentialsDto' => $credentialsDto,
        ]);
    }
}
