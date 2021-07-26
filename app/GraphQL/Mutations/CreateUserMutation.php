<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Ticket\Modules\Auth\Entity\CredentialsDto;
use App\Ticket\Modules\Auth\Exception\ExceptionAuth;
use App\Ticket\Modules\Auth\Service\AuthService;
use App\Ticket\Modules\User\Entity\UserEntity;
use App\Ticket\Modules\User\Service\UserService;
use Closure;
use Exception;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\Type as GraphQLType;
use Illuminate\Support\Arr;
use Rebing\GraphQL\Error\AuthorizationError;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class CreateUserMutation extends Mutation
{
    private AuthService $authService;
    private UserService $userService;

    public function __construct(AuthService $authService, UserService $userService)
    {
        $this->authService = $authService;
        $this->userService = $userService;
    }

    public function type(): GraphQLType
    {
        return GraphQL::type('token');
    }

    public function args(): array
    {
        return [
            'email' => [
                'name' => 'email',
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required', 'email', 'unique:users,email'],
            ],
            'name' => [
                'name' => 'name',
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required', 'max:250'],
            ],
            'password' => [
                'name' => 'password',
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required', 'confirmed', 'min:6'],
            ],
            'password_confirmation' => [
                'name' => 'password_confirmation',
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required'],
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
     * @throws AuthorizationError
     * @throws Exception
     */
    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields): array
    {
        $newUserArr = Arr::only($args, ['email', 'password', 'name']);

        if (!$this->userService->createUser(UserEntity::fromState($newUserArr))) {
            throw new AuthorizationError('Не получилось создать пользователя');
        }

        try {
            $tokenEntity = $this->authService->getTokenUser(CredentialsDto::fromState($newUserArr));
        } catch (ExceptionAuth $e) {
            throw new AuthorizationError('Не верный логин или пароль');
        }

        return $tokenEntity->toArray();
    }
}
