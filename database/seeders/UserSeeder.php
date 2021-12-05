<?php

namespace Database\Seeders;

use App\Models\User;
use Exception;
use Illuminate\Database\Seeder;
use Webpatser\Uuid\Uuid;

class UserSeeder extends Seeder
{
    public const USER_FOR_TEST = 'ShaevMV@gmail.com';

    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run(): void
    {
        (new User())::factory()->create();
        (new User())::insert([
            'id' => Uuid::generate(),
            'name' => 'Test',
            'email' => self::USER_FOR_TEST,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);
    }
}
