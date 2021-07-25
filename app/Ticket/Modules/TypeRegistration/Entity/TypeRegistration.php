<?php

declare(strict_types=1);

namespace App\Ticket\Modules\TypeRegistration\Entity;

use App\Ticket\Entity\AbstractionEntity;
use Webpatser\Uuid\Uuid;

/**
 * Сущность типа билета
 *
 * Class TypeRegistration
 *
 * @package App\Ticket\TypeRegistration\Entity
 */
final class TypeRegistration extends AbstractionEntity
{
    /**
     * Идентификатор
     *
     * @var Uuid
     */
    protected Uuid $id;

    /**
     * Названия
     *
     * @var string
     */
    protected string $title;

    /**
     * Цена
     *
     * @var Price
     */
    protected Price $price;

    /**
     * Параметры для типа билета
     *
     * @var Parameter|null
     */
    protected ?Parameter $params;

    public function __construct()
    {
        $this->params = null;
    }

    /**
     * @param array $data
     *
     * @return self
     */
    public static function fromState(array $data): self
    {
        $result = (new self())
            ->setId(Uuid::import($data['id']))
            ->setTitle($data['title']);

        if (isset($data['pivot'])) {
            $result->setPrice(Price::fromState($data['pivot']['price']))
                ->setParams(Parameter::fromState($data['pivot']));
        }

        return $result;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return TypeRegistration
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Uuid
     */
    public function getId(): Uuid
    {
        return $this->id;
    }

    /**
     * @param Uuid $id
     * @return TypeRegistration
     */
    public function setId(Uuid $id): TypeRegistration
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return Price
     */
    public function getPrice(): Price
    {
        return $this->price;
    }

    /**
     * @param Price $price
     *
     * @return TypeRegistration
     */
    public function setPrice(Price $price): TypeRegistration
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Parameter|null
     */
    public function getParams(): ?Parameter
    {
        return $this->params;
    }

    /**
     * @param Parameter|null $params
     *
     * @return $this
     */
    public function setParams(?Parameter $params): self
    {
        $this->params = $params;

        return $this;
    }

    protected function getColumnsList(): array
    {
        return [];
    }
}
