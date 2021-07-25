<?php

namespace Database\Factories;

use App\Ticket\Modules\Festival\Entity\FestivalStatus;
use App\Ticket\Modules\Festival\Model\FestivalModel;
use DateInterval;
use DateTimeImmutable;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;
use Webpatser\Uuid\Uuid;

class FestivalModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FestivalModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     *
     * @throws Exception
     */
    public function definition(): array
    {
        $dateStart = (new DateTimeImmutable($this->faker->date()));

        return [
            "id" => Uuid::generate(),
            "title" => $this->faker->jobTitle,
            "date_start" => $dateStart->format('Y-m-d'),
            "date_end" => $dateStart->add(new DateInterval('P10D')),
            "status" => FestivalStatus::STATE_DRAFT_ID,
            "description" => $this->faker->text(200),
        ];
    }
}
