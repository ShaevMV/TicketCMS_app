<?php

declare(strict_types=1);

namespace App\Ticket\Modules\TypeRegistration\Repository;

use App\Ticket\Entity\EntityInterface;
use App\Ticket\Modules\TypeRegistration\Entity\Parameter;
use App\Ticket\Modules\TypeRegistration\Entity\Price;
use App\Ticket\Modules\TypeRegistration\Entity\TypeRegistration;
use App\Ticket\Modules\TypeRegistration\Model\TypeRegistrationModule;
use App\Ticket\Repository\BaseRepository;
use Webpatser\Uuid\Uuid;

/**
 * Class TypeRegistrationRepository
 *
 * Репозиторий для работы с типом билета
 *
 * @package App\Ticket\Modules\TypeRegistration\Repository
 */
final class TypeRegistrationRepository extends BaseRepository
{
    /**
     * @var TypeRegistrationModule
     */
    protected $model;

    /**
     * TypeRegistrationRepository constructor.
     *
     * @param TypeRegistrationModule $typeRegistrationModule
     */
    public function __construct(TypeRegistrationModule $typeRegistrationModule)
    {
        $this->model = $typeRegistrationModule;
    }

    /**
     * Выдать список типов проходок у определённого фестиваля
     *
     * @param Uuid $idFestival
     *
     * @return TypeRegistration[]
     */
    public function getTypeRegistrationForFestival(Uuid $idFestival): array
    {
        $typeRegistrationList = $this->model
            ::leftJoin('type_registration_festival', 'type_registration_id', '=', 'id')
            ->where('type_registration_festival.festival_id', '=', (string)$idFestival)
            ->get()
            ->toArray();

        $typeRegistration = [];

        foreach ($typeRegistrationList as $item) {
            $typeRegistration[] = (new TypeRegistration())
                ->setId(Uuid::import($item['id']))
                ->setTitle($item['title'])
                ->setPrice(Price::fromState($item['price']))
                ->setParams(Parameter::fromState($item['params']));
        }

        return $typeRegistration;
    }

    /**
     * Получить сущность типа билета
     *
     * @param array $data
     *
     * @return EntityInterface
     */
    protected function build(array $data): EntityInterface
    {
        return TypeRegistration::fromState($data);
    }
}
