<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type as GraphQLType;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Bus;
use JetBrains\PhpStorm\ArrayShape;
use Rebing\GraphQL\Support\Mutation;
use Ticket\Auth\Application\Authenticate\ReAuthenticateUserCommand;
use Ticket\Auth\Domain\Token\Token;

class LogoutMutator extends Mutation
{
    use DispatchesJobs;

    protected $attributes = [
        'name' => 'Logout',
        'description' => 'Выход пользователя из системы',
    ];

    #[ArrayShape([])]
    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields): bool
    {
        /** @var Token $token */
        $token = Bus::dispatchNow(
            new ReAuthenticateUserCommand()
        );

        return true;
    }

    public function type(): GraphQLType
    {
        return GraphQLType::boolean();
    }
}
