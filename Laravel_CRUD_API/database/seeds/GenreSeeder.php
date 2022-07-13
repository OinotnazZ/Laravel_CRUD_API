<?php

use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $genres = [
            'Action',
            'Drama',
            'Comedy',
            'Horror'
        ];

        foreach ($genres as $genre){
            \DB::table('Genres') -> insert([
                'description' => $genre,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
