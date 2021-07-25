<?php

declare(strict_types=1);

namespace App\Ticket\Modules\Auth\Repository;

use App\Ticket\Entity\EntityInterface;
use App\Ticket\Modules\Auth\Entity\AccessToken;
use App\Ticket\Modules\Auth\Model\OauthClientsModel;
use App\Ticket\Repository\BaseRepository;
use RuntimeException;

final class OathClientsRepository extends BaseRepository
{
    /**
     * @var OauthClientsModel
     */
    protected $model;

    /**
     * OathClientsRepository constructor.
     * @param OauthClientsModel $clientsModel
     */
    public function __construct(OauthClientsModel $clientsModel)
    {
        $this->model = $clientsModel;
    }

    /**
     * @return AccessToken
     *
     * @throws RuntimeException
     */
    public function getApiAccessToken(): AccessToken
    {
        $data = $this->model
            ::where('password_client', '=', true)
            ->first();

        if (null === $data) {
            throw new RuntimeException("Ключи в базе не записаны");
        }

        return AccessToken::fromState($data->toArray());
    }

    /**
     * @param array $data
     *
     * @return EntityInterface
     */
    protected function build(array $data): EntityInterface
    {
        return AccessToken::fromState($data);
    }
}
