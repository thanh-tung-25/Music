<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            ArtistSeeder::class,
            GenreSeeder::class,
            SongSeeder::class,
            PlaylistSeeder::class,
        ]);
    }
}

