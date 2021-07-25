<?php

namespace App\Ticket\Entity;

use JsonException;

abstract class AbstractionEntityData implements EntityDataInterface
{
    /**
     * Вывести объект в виде json
     *
     * @return string
     * @throws JsonException
     */
    public function toJson(): string
    {
        $vars = get_object_vars($this);

        return json_encode($vars, JSON_THROW_ON_ERROR);
    }
}
