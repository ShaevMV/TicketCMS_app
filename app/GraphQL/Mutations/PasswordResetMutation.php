<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Ticket\Modules\Auth\Aggregate\AuthAggregate;
use App\Ticket\Modules\Auth\Dto\UserDataForNewPasswordDto;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\Type as GraphQLType;
use Illuminate\Support\Arr;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class PasswordResetMutation extends Mutation
{
    protected $attributes = [
        'name' => 'passwordReset',
        'description' => 'Заменить пароль у пользователя',
    ];

    private AuthAggregate $authAggregate;

    public function __construct(AuthAggregate $authAggregate)
    {
        $this->authAggregate = $authAggregate;
    }

    public function type(): GraphQLType
    {
        return GraphQL::type('recoveryPasswordResponse');
    }

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
     * @throws TokenInvalidException
     */
    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields): array
    {
        $newUserPassword = Arr::only($args, ['email', 'password', 'token', 'password_confirmation']);

        return $this->authAggregate->passwordReset(UserDataForNewPasswordDto::fromState($newUserPassword))->toArray();
    }
}
