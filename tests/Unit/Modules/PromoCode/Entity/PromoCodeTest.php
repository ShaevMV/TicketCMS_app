<?php

namespace Tests\Unit\Modules\PromoCode\Entity;

use App\Ticket\Modules\PromoCode\Entity\PromoCode;
use Database\Seeders\FestivalSeeder;
use Database\Seeders\PromoCodeSeeder;
use PHPUnit\Framework\TestCase;

/**
 * Class PromoCodeTest
 *
 * + Получить сущность промо-код из массива
 *
 * @package Tests\Unit\PromoCode\Entity
 */
class PromoCodeTest extends TestCase
{
    /**
     * Получить сущность промо-код из массива
     *
     * @dataProvider stateDataProvider
     *
     * @param array $data
     *
     * @return void
     */
    public function testExample(array $data): void
    {
        $promoCode = PromoCode::fromState($data);
        $arPromoCode = $promoCode->toArray();
        self::assertEquals(ksort($arPromoCode), ksort($data));
    }

    public function stateDataProvider(): array
    {
        return [
            [[
                'id' => PromoCodeSeeder::ID_FOR_TEST_SCALAR,
                'name' => PromoCodeSeeder::NAME_FOR_TEST_SCALAR,
                'date_start' => PromoCodeSeeder::DATE_START_FOR_TEST_SCALAR,
                'date_end' => PromoCodeSeeder::DATE_END_FOR_TEST_SCALAR,
                'delta_price' => PromoCodeSeeder::DELTA_PRICE_FOR_TEST_SCALAR,
                'delta_type' => PromoCodeSeeder::DELTA_TYPE_FOR_TEST_SCALAR,
                'festival_id' => FestivalSeeder::ID_FOR_TEST,
                'active' => true,
            ]]
        ];
    }
}
