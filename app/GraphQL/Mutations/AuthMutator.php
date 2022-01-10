<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\Type as GraphQLType;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Bus;
use JetBrains\PhpStorm\ArrayShape;
use Rebing\GraphQL\Error\AuthorizationError;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use Ticket\Auth\Application\Authenticate\AuthenticateUserCommand;
use Ticket\Auth\Domain\Authenticate\CredentialsDto;
use Ticket\Auth\Domain\Authenticate\ExceptionAuth;
use Ticket\Auth\Domain\Token\Token;
use Ticket\User\Application\User\GetUserCommand;
use Ticket\User\Domain\UserAggregate;
use Ticket\User\Domain\UserLocatorData;

class AuthMutator extends Mutation
{
    use DispatchesJobs;

    protected $attributes = [
        'name' => 'Auth',
        'description' => 'Авторизация пользователя',
    ];

    #[ArrayShape(['email' => "array", 'password' => "array", 'isRememberMe' => "array"])]
    public function args(): array
    {
        return [
            'email' => [
                'name' => 'email',
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required', 'email'],
                'description' => 'Email пользователя для авторизации',
            ],
            'password' => [
                'name' => 'password',
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required'],
                'description' => 'Пароль пользователя для авторизации',
            ],
            'isRememberMe' => [
                'type' => Type::boolean(),
                'default' => false,
                'description' => 'Флаг выбора того что пользователь нажал галочку запомнить меня',
                'selectable' => false, // Does not try to query this from the database
            ]
        ];
    }

    /**
     * @param $root
     * @param array $args
     * @param $context
     * @param ResolveInfo $resolveInfo
     * @param Closure $getSelectFields
     * @return array
     * @throws AuthorizationError
     */
    #[ArrayShape(['user' => "array", 'token' => "array"])]
    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields): array
    {
        try {
            /** @var Token $token */
            $token = Bus::dispatchNow(
                new AuthenticateUserCommand(CredentialsDto::fromState(Arr::only($args, ['email', 'password'])))
            );
            /** @var UserAggregate $userEntity */
            $userEntity = Bus::dispatchNow(
                new GetUserCommand(UserLocatorData::fromStateAuth(Auth::guard()))
            );

            return [
                'user' => $userEntity->toArray(),
                'token' => $token->toArray()
            ];
        } catch (ExceptionAuth $e) {
            throw new AuthorizationError('Не верный логин или пароль');
        }

    }

    public function type(): GraphQLType
    {
        return GraphQL::type('userData');
    }
}
