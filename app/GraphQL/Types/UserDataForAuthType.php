<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Models\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class UserDataForAuthType extends GraphQLType
{
    protected $attributes = [
        'name' => 'UserDataForAuthType',
        'description' => 'Данные пользователя',
        'model' => User::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::string(),
            ],
            'email' => [
                'type' => Type::string(),
                'description' => 'Email'
            ],
            'name' => [
                'type' => Type::string(),
            ],
        ];
    }

    // You can also resolve a field by declaring a method in the class
    // with the following format resolve[FIELD_NAME]Field()
/*    protected function resolveEmailField($root, $args): string
    {
        $a= 4;
        return strtolower($args->email);
    }*/
}
