<?php

declare(strict_types=1);

namespace App\Ticket\Modules\TypeRegistration\Service;

use App\Ticket\Modules\TypeRegistration\DTO\TypeRegistrationViewDTO;
use App\Ticket\Modules\TypeRegistration\Entity\TypeRegistration;
use App\Ticket\Modules\TypeRegistration\Specification\SpecificationAnd;
use App\Ticket\Modules\TypeRegistration\Specification\SpecificationEntity;

/**
 * Class TypeRegistrationListService
 *
 * Сервис для работы с списком типов билетов
 *
 * @package App\Ticket\Modules\TypeRegistration\Service
 */
final class TypeRegistrationListService
{
    /**
     * Сервис спецификаций
     *
     * @var SpecificationService
     */
    private SpecificationService $specificationService;

    /**
     * TypeRegistrationListService constructor.
     *
     * @param SpecificationService $specificationService
     */
    public function __construct(SpecificationService $specificationService)
    {
        $this->specificationService = $specificationService;
    }

    /**
     * Получения списка типов билетов со статусом активности
     *
     * @param TypeRegistration[] $typeRegistration
     * @param SpecificationEntity $specificationEntity
     *
     * @return TypeRegistrationViewDTO[]
     */
    public function getList(array $typeRegistration, SpecificationEntity $specificationEntity): array
    {
        $result = [];

        foreach ($typeRegistration as $item) {
            $active = $this->isActive($item, $specificationEntity);
            $result[] = (new TypeRegistrationViewDTO())
                ->setTypeRegistration($item)
                ->setActive($active);
        }

        return $result;
    }

    /**
     * Проверка на активность по спецификацией
     *
     * @param TypeRegistration $typeRegistration
     * @param SpecificationEntity $specificationEntity
     *
     * @return bool
     */
    private function isActive(TypeRegistration $typeRegistration, SpecificationEntity $specificationEntity): bool
    {
        $listSpecification = $this->specificationService
            ->createList($typeRegistration->getParams());

        return (new SpecificationAnd($listSpecification))
            ->isSatisfiedBy($specificationEntity);
    }
}
