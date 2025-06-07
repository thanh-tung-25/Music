<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('password'), // Mật khẩu mặc định
            'avatar' => $this->faker->imageUrl(100, 100),
            'role' => $this->faker->randomElement(['admin', 'artist', 'user']),
        ];
    }
}

