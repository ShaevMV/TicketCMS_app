<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Ticket\Modules\Auth\Service\UserRecoveryPasswordService;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class RecoveryPasswordMutation extends Mutation
{
    protected $attributes = [
        'name' => 'recoveryPassword',
        'description' => 'Восстановление пароля пользователя',
    ];

    private UserRecoveryPasswordService $userRecoveryPasswordService;

    public function __construct(UserRecoveryPasswordService $userRecoveryPasswordService)
    {
        $this->userRecoveryPasswordService = $userRecoveryPasswordService;
    }

    public function type(): GraphQLType
    {
        return GraphQL::type('recoveryPasswordResponse');
    }

    public function args(): array
    {
        return [
            'email' => [
                'name' => 'email',
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required', 'email', 'unique:users'],
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
     * @throws TokenInvalidException
     */
    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields): array
    {
        $email = $args['email'];

        return $this->userRecoveryPasswordService->requestRestoration($email)->toArray();
    }
}
