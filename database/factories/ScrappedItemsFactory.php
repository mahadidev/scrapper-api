<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ScrappedItems>
 */
class ScrappedItemsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "url" => $this->faker->url(),
            "value" => $this->faker->email(),
            "type" => $this->faker->randomElement(["email", "phone"])
        ];
    }
}
