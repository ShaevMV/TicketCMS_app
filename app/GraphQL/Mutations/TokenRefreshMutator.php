<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Ticket\Modules\Auth\Aggregate\AuthAggregate;
use App\Models\User;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type as GraphQLType;
use Illuminate\Support\Facades\Auth;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use Tymon\JWTAuth\JWTGuard;

class TokenRefreshMutator extends Mutation
{

    protected $attributes = [
        'name' => 'tokenRefresh',
        'description' => 'Перезапрос токина',
    ];
    private AuthAggregate $authAggregate;

    public function __construct(AuthAggregate $authAggregate)
    {
        $this->authAggregate = $authAggregate;
    }

    public function type(): GraphQLType
    {
        return GraphQL::type('token');
    }

    public function resolve(
        $root,
        array $args,
        User $context,
        ResolveInfo $resolveInfo,
        Closure $getSelectFields
    ): array {
        /** @var JWTGuard $auth */
        $auth = Auth::guard('api');

        return $this->authAggregate->refreshToken($auth)->toArray();
    }
}
