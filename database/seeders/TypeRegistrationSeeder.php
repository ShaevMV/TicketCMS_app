<?php

namespace Database\Seeders;

use App\Ticket\Modules\TypeRegistration\Model\TypeRegistrationModule;
use App\Ticket\Modules\TypeRegistration\Service\SpecificationService;
use Illuminate\Database\Seeder;

class TypeRegistrationSeeder extends Seeder
{
    public const ID_FOR_TEST = '04140f60-620d-11ea-a5ac-0910e3fe4aca';
    public const TITLE_FOR_TEST = 'Тест';
    public const PRICE_FOR_TEST = 1000;

    public const ID_FOR_TEST_COUNT = '30ab3dc0-8e22-11ea-ab7a-6701ffeafb5c';
    public const TITLE_FOR_TEST_COUNT = 'Тест коллективного билета';
    public const PRICE_FOR_TEST_COUNT = 2500;
    public const PARAMS_FOR_TEST_COUNT = [
        SpecificationService::KEY_COUNT => 4
    ];


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        (new TypeRegistrationModule())::insert([
                'id' => self::ID_FOR_TEST,
                'title' => self::TITLE_FOR_TEST,
            ]);

        (new TypeRegistrationModule())::insert([
                'id' => self::ID_FOR_TEST_COUNT,
                'title' => self::TITLE_FOR_TEST_COUNT,
            ]);
    }
}
