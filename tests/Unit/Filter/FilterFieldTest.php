<?php

namespace Tests\Unit\Filter;

use App\Ticket\Filter\Entity\FilterItem;
use App\Ticket\Filter\FilterList;
use App\Ticket\Filter\Service\Factory\FilterDate;
use App\Ticket\Filter\Service\Factory\FilterDateBetween;
use App\Ticket\Filter\Service\Factory\FilterInteger;
use App\Ticket\Filter\Service\Factory\FilterString;
use App\Ticket\Filter\Service\FilterFactoryService;
use App\Ticket\Filter\Service\FilterListService;
use App\Ticket\Modules\Festival\Model\FestivalModel;
use Database\Seeders\FestivalSeeder;
use Database\Seeders\TypeRegistrationSeeder;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\TestCase;

//use Illuminate\Foundation\Testing\WithFaker;
//use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class FilterFieldTest
 * @package Tests\Unit\Filter
 *
 * + Создать фильтр из данных
 * + Создать набор фильтров
 * + Реализовать запрос по фильтру
 */
class FilterFieldTest extends TestCase
{
    private FilterListService $filterListService;
    private FilterList $filterList;

    /**
     * Создать фильтр из данных
     *
     * @dataProvider dataProviderFilter
     *
     * @param object $class
     * @param array $data
     *
     * @return void
     */
    public function testCreateFilter(array $data, object $class): void
    {
        $filter = (new FilterItem())
            ->setValue($data[FilterItem::VALUE_INDEX])
            ->setFieldAndTable((string)$data[FilterItem::FIELD_INDEX])
            ->setType((string)$data[FilterItem::TYPE_INDEX]);

        self::assertInstanceOf(get_class($class), FilterFactoryService::initFilter($filter));
    }

    /**
     * Создать набор фильтров
     *
     * @dataProvider dataProviderFilter
     *
     * @param array $data
     *
     * @return void
     *
     */
    public function testCreateFilterList(array $data): void
    {
        static $filters = [];

        $filter = (new FilterItem())
            ->setValue($data[FilterItem::VALUE_INDEX])
            ->setFieldAndTable((string)$data[FilterItem::FIELD_INDEX])
            ->setType((string)$data[FilterItem::TYPE_INDEX]);

        $filters[] = FilterFactoryService::initFilter($filter);
        $this->filterList->setFilterFields($filters);

        self::assertInstanceOf(FilterList::class, $this->filterList);
        self::assertIsArray($this->filterList->getFilterFields());
        self::assertCount(count($filters), $this->filterList->getFilterFields());
    }

    /**
     * Реализовать запрос по фильтру
     *
     * @dataProvider dataProviderFilter
     *
     * @param array $data
     *
     * @return void
     */
    public function testFiltration(array $data): void
    {
        static $filters = [];

        $filterItems = (new FilterItem())
            ->setValue($data[FilterItem::VALUE_INDEX])
            ->setFieldAndTable((string)$data[FilterItem::FIELD_INDEX])
            ->setType((string)$data[FilterItem::TYPE_INDEX]);

        $filters[] = FilterFactoryService::initFilter($filterItems);

        $festival = new FestivalModel();
        $this->filterList->setFilterFields($filters);

        $fromFiltered = $this->filterList->filtration($festival::getQuery(), $festival);
        if (null !== $fromFiltered) {
            $fromFiltered = $fromFiltered->get();
            self::assertTrue($fromFiltered->count() > 0);
            self::assertNotEquals($festival::count(), $fromFiltered->count());
        }
    }

    /**
     * Тестирования создания списка фильтров из серого запроса
     *
     * @dataProvider dataProviderFilter
     *
     * @param array $data
     */
    public function testFilterListService(array $data): void
    {
        static $filters = [];
        $filters[] = $data;
        $filterList = $this->filterListService->getFilterListOfRaw($filters);

        self::assertInstanceOf(FilterList::class, $filterList);
    }

    /**
     * @return array
     */
    public function dataProviderFilter(): array
    {
        $filterItem = new FilterItem();

        return [
            [[
                FilterItem::TYPE_INDEX => FilterFactoryService::INTEGER_TYPE,
                FilterItem::FIELD_INDEX => 'festivals.status',
                FilterItem::VALUE_INDEX => FestivalSeeder::STATUS_FOR_TEST,
            ], new FilterInteger($filterItem)],
            [[
                FilterItem::TYPE_INDEX => FilterFactoryService::STRING_TYPE,
                FilterItem::FIELD_INDEX => 'festivals.title',
                FilterItem::VALUE_INDEX => FestivalSeeder::TITLE_FOR_TEST,
            ], new FilterString($filterItem)],
            [[
                FilterItem::TYPE_INDEX => FilterFactoryService::DATE_TYPE,
                FilterItem::FIELD_INDEX => 'festivals.date_start',
                FilterItem::VALUE_INDEX => FestivalSeeder::DATE_START_FOR_TEST,
            ], new FilterDate($filterItem)],
            [[
                FilterItem::TYPE_INDEX => FilterFactoryService::DATE_BETWEEN_TYPE,
                FilterItem::FIELD_INDEX => 'festivals.date_start',
                FilterItem::VALUE_INDEX => [
                    FestivalSeeder::DATE_START_FOR_TEST,
                    FestivalSeeder::DATE_END_FOR_TEST,
                ]
            ], new FilterDateBetween($filterItem)],
            [[
                FilterItem::TYPE_INDEX => FilterFactoryService::INTEGER_TYPE,
                FilterItem::FIELD_INDEX => 'typeRegistration.price',
                FilterItem::VALUE_INDEX => TypeRegistrationSeeder::PRICE_FOR_TEST
            ], new FilterInteger($filterItem)],
            [[
                FilterItem::TYPE_INDEX => FilterFactoryService::STRING_TYPE,
                FilterItem::FIELD_INDEX => 'typeRegistration.title',
                FilterItem::VALUE_INDEX => TypeRegistrationSeeder::TITLE_FOR_TEST
            ], new FilterString($filterItem)],
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->filterListService = $this->app->make(FilterListService::class);
        $this->filterList = $this->app->make(FilterList::class);
    }
}
