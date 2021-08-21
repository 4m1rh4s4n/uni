<?php

namespace Database\Factories;

use App\Models\Awards;
use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;


class AwardsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Awards::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $fakerFa = Faker::create('fa_IR');

        return [
            'name' => $fakerFa->paragraph(),
            'language' => '1'
        ];
    }
    public function english()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => $this->faker->paragraph(),
                'language' => '0'
            ];
        });
    }
}
