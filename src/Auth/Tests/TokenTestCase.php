<?php

namespace Ticket\Auth\Tests;

use JetBrains\PhpStorm\Pure;
use Ticket\Auth\Domain\Token\Token;

trait TokenTestCase
{
    #[Pure]
    protected function getToken(): Token
    {
        return new Token(
            'test',
            213
        );
    }
}

