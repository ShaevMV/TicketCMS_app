<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

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
use Throwable;

class RegistrationMutation extends Mutation
{
    protected $attributes = [
        'name' => 'registration',
        'description' => 'Регистрация нового пользователя',
    ];


    public function type(): GraphQLType
    {
        return GraphQL::type('userAfterRegistration');
    }

    public function args(): array
    {
        return [
            'name' => [
                'name' => 'name',
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required', 'max:250'],
                'description' => 'Имя пользователя',
            ],
            'email' => [
                'name' => 'email',
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required', 'email', 'unique:users'],
                'description' => 'Email пользователя',
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
                'rules' => ['required'],
                'description' => 'Повтор пароля',
            ],
        ];
    }


    public function validationErrorMessages(array $args = []): array
    {
        return [
            'name.required' => 'Пожалуйста введите своё имя',
            'name.string' => 'Ваше имя должно быть строкой',
            'email.required' => 'Пожалуйста введите своё email',
            'email.email' => 'Пожалуйста, введите действительный email',
            'email.unique' => 'Извините, этот адрес электронной почты уже используется',
            'password.confirmed' => 'Пароль не уникален',
            'password.required' => 'Пароль не может быть пустым',
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
        /*$newUserArr = Arr::only($args, ['email', 'password', 'name']);

        try {
            $userEntity = $this->userService->createUser(UserEntity::fromState($newUserArr));
            $tokenEntity = $this->authService->getTokenUser(CredentialsDto::fromState($newUserArr));
        } catch (ExceptionAuth $e) {
            throw new AuthorizationError('Не верный логин или пароль');
        } catch (Throwable $exception) {
            throw new AuthorizationError('Не получилось создать пользователя');
        }

        return [
            'user' => $userEntity->toArray(),
            'token' => $tokenEntity->toArray()
        ];*/
        return [];
    }

}
