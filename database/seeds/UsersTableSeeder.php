<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [ 'screen_name' => 'test1', 'name' => 'test_user1', 'profile_image' => 'monster/monster_a', 'password' => bcrypt('password') ],
            [ 'screen_name' => 'test2', 'name' => 'test_user2', 'profile_image' => 'monster/monster_b', 'password' => bcrypt('password') ],
            [ 'screen_name' => 'test3', 'name' => 'test_user3', 'profile_image' => 'monster/monster_c', 'password' => bcrypt('password') ],
        ]);

        factory(App\Models\User::class, 10)->create();
    }
}
