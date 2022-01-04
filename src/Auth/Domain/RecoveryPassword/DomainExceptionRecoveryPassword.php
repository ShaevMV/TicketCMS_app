<?php

declare(strict_types=1);

namespace Ticket\Auth\Domain\RecoveryPassword;

use GraphQL\Error\ClientAware;
use GraphQL\Error\Error;

class DomainExceptionRecoveryPassword extends Error implements ClientAware
{
    public function isClientSafe(): bool
    {
        return true;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return 'recoveryPassword';
    }
}
