<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class TokenType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Token',
        'description' => 'Токен для авторизации',
    ];

    public function fields(): array
    {
        return [
            'accessToken' => [
                'type' => Type::string(),
                'description' => 'Токен для авторизации',
            ],
            'tokenType' => [
                'type' => Type::string(),
                'description' => 'Тип авторизации',
            ],
            'expiresIn' => [
                'type' => Type::int(),
                'description' => 'Время жизни токена',
            ],
        ];
    }
}
