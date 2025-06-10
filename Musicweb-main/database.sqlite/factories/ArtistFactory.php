<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ArtistFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'bio' => $this->faker->paragraph(),
            'avatar' => $this->faker->imageUrl(100, 100),
        ];
    }
}

