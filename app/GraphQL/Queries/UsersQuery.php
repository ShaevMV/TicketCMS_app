<?php
namespace App\GraphQL\Queries;

use App\Models\User;
use Closure;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Bus;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Ticket\User\Application\User\GetUserCommand;
use Ticket\User\Domain\UserAggregate;
use Ticket\User\Domain\UserLocatorData;

class UsersQuery extends Query
{
    protected $attributes = [
        'name' => 'users',
    ];

    public function type(): Type
    {
        return GraphQL::type('user');
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        /** @var UserAggregate $userEntity */
        $userEntity = Bus::dispatchNow(
            new GetUserCommand(UserLocatorData::fromStateAuth(Auth::guard()))
        );

        return $userEntity->toArray();
    }
}
