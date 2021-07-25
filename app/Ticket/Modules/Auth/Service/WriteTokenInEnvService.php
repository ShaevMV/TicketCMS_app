<?php

namespace App\Ticket\Modules\Auth\Service;

use App\Ticket\Modules\Auth\Repository\EnvRepository;
use App\Ticket\Modules\Auth\Repository\OathClientsRepository;
use Illuminate\Support\Facades\Artisan;
use RuntimeException;

final class WriteTokenInEnvService
{
    private OathClientsRepository $oathClientsRepository;
    private WriteInEnv $writeInEnv;
    private EnvRepository $envRepository;

    public function __construct(
        OathClientsRepository $oathClientsRepository,
        WriteInEnv $writeInEnv,
        EnvRepository $envRepository
    )
    {
        $this->oathClientsRepository = $oathClientsRepository;
        $this->writeInEnv = $writeInEnv;
        $this->envRepository = $envRepository;
    }

    /**
     * @return bool
     * @throws RuntimeException
     */
    public function init(): bool
    {
        $apiAccessToken = $this->oathClientsRepository->getApiAccessToken();
        $envDtoList = $this->envRepository->getEnvDtoList($apiAccessToken);
        $this->writeInEnv->editValue($envDtoList);

        // Очистка кеша
        Artisan::call('cache:clear');

        // Копируем значение в другие файлы состояний среды
        $this->writeInEnv->editValue($envDtoList, WriteInEnv::PATH_FRONTEND);

        return true;
    }
}
