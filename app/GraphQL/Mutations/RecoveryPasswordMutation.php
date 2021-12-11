<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Ticket\Modules\Auth\Aggregate\AuthAggregate;
use App\Ticket\Modules\Auth\Exception\DomainExceptionRecoveryPassword;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Closure;

class RecoveryPasswordMutation extends Mutation
{
    protected $attributes = [
        'name' => 'recoveryPassword',
        'description' => 'Восстановление пароля пользователя',
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
     * @throws TokenInvalidException
     * @throws DomainExceptionRecoveryPassword
     */
    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields): array
    {
        $email = $args['email'];

        return $this->authAggregate->sendLinkForRecoveryPassword($email)->toArray();
    }
}
