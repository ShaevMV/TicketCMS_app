<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use App\Ticket\Modules\Auth\Entity\CredentialsDto;
use App\Ticket\Modules\Auth\Exception\ExceptionAuth;
use App\Ticket\Modules\Auth\Service\AuthService;
use Closure;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type as GraphQLType;
use Illuminate\Support\Arr;
use Rebing\GraphQL\Error\AuthorizationError;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class AuthMutator extends Mutation
{
    private AuthService $authService;

    protected $attributes = [
        'name' => 'Auth',
        'description' => 'Авторизация пользователя',
    ];

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

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
    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields): array
    {
        $credentials = Arr::only($args, ['email', 'password']);
        try {
            $tokenEntity = $this->authService->getTokenUser(CredentialsDto::fromState($credentials));
        } catch (ExceptionAuth $e) {
            throw new AuthorizationError('Не верный логин или пароль');
        }

        return $tokenEntity->toArray();
    }

    public function type(): GraphQLType
    {
        return GraphQL::type('token');
    }
}
