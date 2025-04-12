<?php

namespace Database\Factories;

use App\Enums\TravelOrderStatus;
use App\Models\TravelOrder;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TravelOrder>
 */
class TravelOrderFactory extends Factory
{

    protected $model = TravelOrder::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('+1 days', '+1 month');
        $endDate = (clone $startDate)->modify('+'.rand(1, 10).' days');

        return [
            'user_id' => User::factory(), // Ou atribua depois no seeder
            'destino' => [
                'city' => fake()->city(),
                'state' => fake()->state(),
                'country'   => fake()->country(),
              ], // Altere conforme seu cast
            'status' => Arr::random(TravelOrderStatus::values()), // Altere conforme enum ou cast
            'data_ida' => Carbon::instance($startDate),
            'data_volta' => Carbon::instance($endDate),
        ];
    }
}
