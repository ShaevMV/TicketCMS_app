<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call(FestivalSeeder::class);
        $this->call(TypeRegistrationSeeder::class);
        $this->call(PromoCodeSeeder::class);
        $this->call(UserSeeder::class);
    }
}
