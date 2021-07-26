<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class TokenType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Token',
        'description' => 'Token for auth user',
    ];

    public function fields(): array
    {
        return [
            'accessToken' => [
                'type' => Type::string(),
                'description' => 'Token for auth user',
            ],
            'tokenType' => [
                'type' => Type::string(),
                'description' => 'Type token',
            ],
            'expiresIn' => [
                'type' => Type::int(),
                'description' => 'Time live token',
            ],
        ];
    }
}
