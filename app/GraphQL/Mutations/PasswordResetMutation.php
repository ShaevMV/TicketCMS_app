<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\Type as GraphQLType;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Bus;
use JetBrains\PhpStorm\ArrayShape;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use Ticket\Auth\Application\RecoveryPassword\SetNewPasswordUserCommand;
use Ticket\Auth\Domain\RecoveryPassword\ResponseRecoveryPassword;
use Ticket\Auth\Domain\RecoveryPassword\UserDataForNewPassword;

class PasswordResetMutation extends Mutation
{
    protected $attributes = [
        'name' => 'passwordReset',
        'description' => 'Заменить пароль у пользователя',
    ];

    public function type(): GraphQLType
    {
        return GraphQL::type('recoveryPasswordResponse');
    }

    #[ArrayShape(['token' => "array", 'email' => "array", 'password' => "array", 'password_confirmation' => "array"])]
    public function args(): array
    {
        return [
            'token' => [
                'name' => 'token',
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required'],
                'description' => 'Token из письма',
            ],
            'email' => [
                'name' => 'email',
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required', 'email'],
                'description' => 'Token из письма',
            ],
            'password' => [
                'name' => 'password',
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required', 'confirmed', 'min:6'],
                'description' => 'Пароль пользователя для авторизации',
            ],
            'password_confirmation' => [
                'name' => 'password_confirmation',
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required', 'min:6'],
                'description' => 'Пароль пользователя для авторизации',
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
        $newUserPassword = Arr::only($args, ['email', 'password', 'token', 'password_confirmation']);

        /** @var ResponseRecoveryPassword $result */
        $result = Bus::dispatchNow(
            new SetNewPasswordUserCommand(UserDataForNewPassword::fromState($newUserPassword))
        );

        return $result->toArray();
    }
}
