<?php

declare(strict_types=1);

namespace App\Ticket\Modules\Auth\Repository;

use App\Ticket\Modules\Auth\Dto\EnvDto;
use App\Ticket\Modules\Auth\Entity\AccessToken;
use App\Ticket\Modules\Auth\Helpers\EnvHelper;

class EnvRepository
{
    /**
     * @param AccessToken $accessToken
     * @return EnvDto[]
     */
    public function getEnvDtoList(AccessToken $accessToken): array
    {
        $envDto = [];
        foreach ($accessToken->toArray() as $key => $value) {
            $envDto[] = (new EnvDto())
                ->setKey(EnvHelper::ARRAY_KEYS[$key])
                ->setValue((string)$value);
        }

        return $envDto;
    }
}
