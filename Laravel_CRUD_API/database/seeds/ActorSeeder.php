<?php

use Illuminate\Database\Seeder;

class ActorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $actors = [
            'John Wayne',
            'Tom Hanks',
            'Eddie Murphy',
            'Bill Skarsgård'
        ];

        foreach ($actors as $actor){
            \DB::table('Actors') -> insert([
                'name' => $actor,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
