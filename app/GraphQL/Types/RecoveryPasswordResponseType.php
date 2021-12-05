<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class RecoveryPasswordResponseType extends GraphQLType
{
    protected $attributes = [
        'name' => 'recoveryPasswordResponse',
        'description' => 'Ответ после запроса восстановления пароля пользователя',
    ];

    public function fields(): array
    {
        return [
            'success' => [
                'type' => Type::boolean(),
                'description' => 'Успех отправки письма на почту',
            ],
            'userMessage' => [
                'type' => Type::string(),
                'description' => 'Пользовательское сообщение',
            ],
        ];
    }
}
