<?php

namespace Tests\Unit\Model;

use App\Ticket\Modules\Festival\Entity\FestivalStatus;
use App\Ticket\Modules\Festival\Model\FestivalModel;
use Carbon\Carbon;
use Database\Seeders\FestivalSeeder;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Collection;
use Tests\TestCase;

class ModelTest extends TestCase
{
    use DatabaseTransactions;

    private FestivalModel $model;
    private string $id;

    /**
     * Записать данные в базу / найти запись по его id
     */
    public function testCreate(): void
    {
        $id = uniqid('', true);
        $this->assertTrue($this->model::insert([
            'id' => $id,
            'title' => 'тест из теста',
            'date_start' => Carbon::today()->toDateString(),
            'date_end' => Carbon::today()->addDays(5)->toDateString(),
            'status' => FestivalStatus::STATE_PUBLISHED_ID
        ]));
        self::assertNotEmpty($this->model::find($id));

        self::assertTrue($this->model::insert([]));
        self::assertNull($this->model::find($id . '21'));
    }

    /**
     * обновить данные фестиваля
     */
    public function testUpdate(): void
    {
        self::assertTrue($this->model
                ::where('id', '=', $this->id)
                ->update([
                    'status' => '1'
                ]) > 0);

        $festival = $this->model::find($this->id);

        self::assertEquals(1, $festival->status);
    }

    /**
     * Удалить
     * @throws Exception
     */
    public function testDelete(): void
    {
        self::assertEquals(1, $this->model::whereId($this->id)->delete());
        self::assertNull($this->model::find($this->id));
    }

    /**
     * Поиск
     */
    public function testWhereAndGet(): void
    {
        self::assertInstanceOf(FestivalModel::class, $this->model::where('id', '=', $this->id)->first());
        self::assertInstanceOf(Collection::class, $this->model::where('id', '=', $this->id)->get());
        self::assertEmpty($this->model::where('id', '=', $this->id . '54')->get()->toArray());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->model = new FestivalModel();
        $this->id = FestivalSeeder::ID_FOR_TEST;
    }
}
