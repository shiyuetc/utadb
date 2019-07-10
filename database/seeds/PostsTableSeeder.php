<?php

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->insert([
            [ 'id' => str_pad(str_replace('.', '', microtime(true) + 0), 14, '0', STR_PAD_RIGHT), 'user_id' => '1', 'song_id' => '00001', 'old_state' => '0', 'state' => '1' ],
            [ 'id' => str_pad(str_replace('.', '', microtime(true) + 1), 14, '0', STR_PAD_RIGHT), 'user_id' => '1', 'song_id' => '00002', 'old_state' => '0', 'state' => '2' ],
            [ 'id' => str_pad(str_replace('.', '', microtime(true) + 2), 14, '0', STR_PAD_RIGHT), 'user_id' => '2', 'song_id' => '00003', 'old_state' => '0', 'state' => '3' ],
        ]);
    }
}
