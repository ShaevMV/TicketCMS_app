<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\Type as GraphQLType;
use Illuminate\Support\Facades\Bus;
use JetBrains\PhpStorm\ArrayShape;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use Ticket\Auth\Application\RecoveryPassword\RecoveryPasswordUserCommand;
use Ticket\Auth\Domain\RecoveryPassword\ResponseRecoveryPassword;

class RecoveryPasswordMutation extends Mutation
{
    protected $attributes = [
        'name' => 'recoveryPassword',
        'description' => 'Восстановление пароля пользователя',
    ];

    public function type(): GraphQLType
    {
        return GraphQL::type('recoveryPasswordResponse');
    }

    #[ArrayShape(['email' => "array"])]
    public function args(): array
    {
        return [
            'email' => [
                'name' => 'email',
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required', 'email'],
                'description' => 'Email пользователя',
            ],
        ];
    }

    /**
     * @param $root
     * @param array $args
     * @param $context
     * @param ResolveInfo $resolveInfo
     * @param Closure $getSelectFields
     * @return array
     */
    #[ArrayShape(['success' => "bool", 'userMessage' => "string"])]
    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields): array
    {
        /** @var ResponseRecoveryPassword $responseRecoveryPassword */
        $responseRecoveryPassword = Bus::dispatchNow(new RecoveryPasswordUserCommand($args['email']));

        return $responseRecoveryPassword->toArray();
    }
}
