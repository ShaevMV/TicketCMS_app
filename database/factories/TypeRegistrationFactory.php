<?php

namespace Database\Factories;

use App\Ticket\Modules\TypeRegistration\Model\TypeRegistrationModule;
use Illuminate\Database\Eloquent\Factories\Factory;

class TypeRegistrationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TypeRegistrationModule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->jobTitle,
        ];
    }
}
