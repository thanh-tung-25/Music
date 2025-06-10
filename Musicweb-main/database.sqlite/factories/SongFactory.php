<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Artist;
use App\Models\Genre;

class SongFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'artist_id' => Artist::inRandomOrder()->first()->id ?? Artist::factory(),
            'genre_id' => Genre::inRandomOrder()->first()->id ?? Genre::factory(),
            'file_url' => $this->faker->url(),
            'duration' => rand(180, 300), // 3-5 phút
        ];
    }
}



