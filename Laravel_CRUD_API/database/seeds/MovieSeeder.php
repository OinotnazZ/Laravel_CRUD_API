<?php

use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $movies = [
            (object)[
                'title'     => 'El Dorado',
                'year'      => '1966',
                'released'  => '1966-12-17',
                'runtime'   => '126',
                'director'  => 'Howard Hawks',
                'actors'    => [1],
                'genres'    => [1]
            ],
            (object)[
                'title'     => 'Forrest Gump',
                'year'      => '1994',
                'released'  => '1994-07-06',
                'runtime'   => '142',
                'director'  => 'Robert Zemeckis',
                'actors'    => [2],
                'genres'    => [2]
            ],
            (object)[
                'title'     => 'Shrek',
                'year'      => '2001',
                'released'  => '2001-05-18',
                'runtime'   => '90',
                'director'  => 'Andrew Adamson & Vicky Jenson',
                'actors'    => [3],
                'genres'    => [3]
            ],
            (object)[
                'title'     => 'IT',
                'year'      => '2017',
                'released'  => '2017-09-08',
                'runtime'   => '135',
                'director'  => 'Andy Muschietti',
                'actors'    => [4],
                'genres'    => [4]
            ],
        ];

        foreach ($movies as $movie){
            /*\DB::table('Movies') -> insert([
                'title' => $movie->title,
                'year' => $movie->year,
                'released' => $movie->released,
                'runtime' => $movie->runtime,
                'director' => $movie->director,
                'created_at' => now(),
                'updated_at' => now()
            ]);*/

            $newMovie = \App\Movie::create([
                'title' => $movie->title,
                'year' => $movie->year,
                'released' => $movie->released,
                'runtime' => $movie->runtime,
                'imdb_votes' => rand(10,100),
                'director' => $movie->director,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $newMovie->actors()->sync($movie->actors);
            $newMovie->genres()->sync($movie->genres);

        }
    }
}
