<?php

use Illuminate\Database\Seeder;

class SongsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('songs')->insert([
            [ 'id' => '00001', 'title' => 'test_song1', 'artist_id' => '0001', 'artist' => 'test_artist1' ],
            [ 'id' => '00002', 'title' => 'test_song2', 'artist_id' => '0001', 'artist' => 'test_artist1' ],
            [ 'id' => '00003', 'title' => 'test_song3', 'artist_id' => '0002', 'artist' => 'test_artist2' ],
        ]);
    }
}
