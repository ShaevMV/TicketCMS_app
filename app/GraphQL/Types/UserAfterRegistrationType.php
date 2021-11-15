<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Models\User;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class UserAfterRegistrationType extends GraphQLType
{
    protected $attributes = [
        'name' => 'UserDataForRegistration',
        'description' => 'Данные пользователя после регистрации',
        'model' => User::class,
    ];

    public function fields(): array
    {
        return [
            'token' => [
                'type' => GraphQL::type('token')
            ],
            'user' => [
                'type' => GraphQL::type('user')
            ]
        ];
    }
}
