<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Ticket\Modules\Auth\Service\AuthService;
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
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
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

        $tokenEntity = $this->authService->refreshToken($auth);

        return $tokenEntity->toArray();
    }
}
