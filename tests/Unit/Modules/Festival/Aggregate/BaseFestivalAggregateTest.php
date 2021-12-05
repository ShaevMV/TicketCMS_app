<?php

namespace Tests\Unit\Modules\Festival\Aggregate;

use App\Ticket\Modules\Festival\Aggregate\BaseFestivalsAggregate;
use App\Ticket\Modules\Festival\Dto\FestivalRawDto;
use App\Ticket\Modules\Festival\Entity\FestivalStatus;
use Carbon\Carbon;
use Database\Seeders\FestivalSeeder;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Webpatser\Uuid\Uuid;

/**
 * + Создание фестиваля Фестиваль создан
 * + Получить активный фестиваль
 * + Получить определённый фестиваль
 * + Получить список фестивалей
 * + Открыть продажу билетов / Закрыть продажу билетов
 * - Фестиваль удалён
 */
class BaseFestivalAggregateTest extends TestCase
{
    use DatabaseTransactions;

    private BaseFestivalsAggregate $baseFestivalsAggregate;

    /**
     * Получить активный фестиваль
     */
    public function testGetActive(): void
    {
        $festivalAggregate = $this->baseFestivalsAggregate->getActive();

        self::assertNotNull($festivalAggregate->getFestival());
    }

    /**
     * Получить активный фестиваль
     */
    public function testGet(): void
    {
        $festivalAggregate = $this->baseFestivalsAggregate->get(Uuid::import(FestivalSeeder::ID_FOR_TEST));

        self::assertNotNull($festivalAggregate->getFestival());
    }

    /**
     *  Получить список фестивалей
     */
    public function testGetList(): void
    {
        $festivalAggregates = $this->baseFestivalsAggregate->getList();

        self::assertNotEmpty($festivalAggregates);
    }


    /**
     * Создание фестиваля Фестиваль создан
     *
     * @throws Exception
     */
    public function testCreate(): void
    {
        $festivalAggregate = $this->baseFestivalsAggregate->createFestival(FestivalRawDto::fromState([
            'title' => 'Test',
            'description' => 'test',
            'date_start' => Carbon::today()->toDateString(),
            'date_end' => Carbon::today()->addDay()->toDateString(),
            'status' => FestivalStatus::STATE_DRAFT_ID,
        ]));

        self::assertNotNull($festivalAggregate->getFestival());
    }


    /**
     * @throws Exception
     */
    public function testChangeActivity(): void
    {
        $festivalAggregate = $this->baseFestivalsAggregate->get(Uuid::import(FestivalSeeder::ID_FOR_TEST_NOT_ACTIVE));
        $festival = $festivalAggregate->changeActivity()->getFestival();

        self::assertEquals(FestivalStatus::STATE_PUBLISHED_ID, $festival['status']);

        $festival = $festivalAggregate->changeActivity()->getFestival();

        self::assertEquals(FestivalStatus::STATE_DRAFT_ID, $festival['status']);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->baseFestivalsAggregate = $this->app->get(BaseFestivalsAggregate::class);
    }
}
