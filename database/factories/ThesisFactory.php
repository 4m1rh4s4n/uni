<?php

namespace Database\Factories;

use App\Models\Model;
use App\Models\Thesis;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;


class ThesisFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Thesis::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $fakerFa = Faker::create('fa_IR');
        return [
            'name' => $fakerFa->name() . ' ' . $fakerFa->lastName(),
            'project_name' => $fakerFa->paragraph(),
            'degree' => $fakerFa->text(20),
            'defense_date' => $fakerFa->date()
        ];
    }

    public function english()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => $this->faker->name() . ' ' . $this->faker->lastName(),
                'project_name' => $this->faker->paragraph(),
                'degree' => $this->faker->text(20),
            ];
        });
    }
}
