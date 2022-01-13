<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\User;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type as GraphQLType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Bus;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use Ticket\Auth\Application\Token\RefreshingTokenCommand;
use Ticket\Auth\Domain\Token\Token;
use Tymon\JWTAuth\JWTGuard;

class TokenRefreshMutator extends Mutation
{

    protected $attributes = [
        'name' => 'tokenRefresh',
        'description' => 'Перезапрос токина',
    ];

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
        /** @var Token $result */
        $result = Bus::dispatchNow(new RefreshingTokenCommand());

        return $result->toArray();
    }
}
