<?php

use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_statuses')->insert([
            [ 'user_id' => '1', 'song_id' => '00001', 'state' => '1' ],
            [ 'user_id' => '1', 'song_id' => '00002', 'state' => '2' ],
            [ 'user_id' => '2', 'song_id' => '00003', 'state' => '3' ],
        ]);
    }
}
