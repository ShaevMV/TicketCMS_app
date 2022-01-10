<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Models\User;
use JetBrains\PhpStorm\ArrayShape;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class UserDataType extends GraphQLType
{
    protected $attributes = [
        'name' => 'UserData',
        'description' => 'Данные пользователя после регистрации'
    ];

    #[ArrayShape(['token' => "array", 'user' => "array"])]
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
