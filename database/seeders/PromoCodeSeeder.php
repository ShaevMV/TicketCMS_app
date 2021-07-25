<?php

namespace Database\Seeders;

use App\Ticket\Modules\PromoCode\Entity\Enum\DeltaTypeEnum;
use App\Ticket\Modules\PromoCode\Model\PromoCodeModel;
use Illuminate\Database\Seeder;

class PromoCodeSeeder extends Seeder
{
    public const ID_FOR_TEST_SCALAR = 'b8f2b430-ae32-11ea-bc80-53f3a458ec28';
    public const NAME_FOR_TEST_SCALAR = 'COVID_19';
    public const DELTA_PRICE_FOR_TEST_SCALAR = '100';
    public const DELTA_TYPE_FOR_TEST_SCALAR = DeltaTypeEnum::OPTION_SCALAR;
    public const DATE_START_FOR_TEST_SCALAR = '2020-01-01';
    public const DATE_END_FOR_TEST_SCALAR = '2020-06-01';

    public const ID_FOR_TEST_PERCENT = 'b8f321d0-ae32-11ea-94e6-7f18edd87780';
    public const DELTA_PRICE_FOR_TEST_PERCENT = '10';
    public const DELTA_TYPE_FOR_TEST_PERCENT = DeltaTypeEnum::OPTION_PERCENT;
    public const NAME_FOR_TEST_PERCENT = 'pestilence';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        (new PromoCodeModel())::insert([
            'id' => self::ID_FOR_TEST_PERCENT,
            'name' => self::NAME_FOR_TEST_PERCENT,
            'festival_id' => FestivalSeeder::ID_FOR_TEST,
            'delta_price' => self::DELTA_PRICE_FOR_TEST_PERCENT,
            'delta_type' => self::DELTA_TYPE_FOR_TEST_PERCENT,
        ]);

        (new PromoCodeModel())::insert([
            'id' => self::ID_FOR_TEST_SCALAR,
            'name' => self::NAME_FOR_TEST_SCALAR,
            'festival_id' => FestivalSeeder::ID_FOR_TEST,
            'delta_price' => self::DELTA_PRICE_FOR_TEST_SCALAR,
            'delta_type' => self::DELTA_TYPE_FOR_TEST_SCALAR,
            'date_start' => self::DATE_START_FOR_TEST_SCALAR,
            'date_end' => self::DATE_END_FOR_TEST_SCALAR,
        ]);
    }
}
