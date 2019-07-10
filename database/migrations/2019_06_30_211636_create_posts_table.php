<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->string('id', 14)->comment('主キー');
            $table->integer('user_id')->unsigned();
            $table->string('song_id', 18);
            $table->integer('old_state')->comment('状態 [1:stacked, 2:training, 3:mastered]');
            $table->integer('state')->comment('状態 [1:stacked, 2:training, 3:mastered]');
            $table->integer('like_count')->default(0)->comment('いいねの数');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->primary('id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('song_id')->references('id')->on('songs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
