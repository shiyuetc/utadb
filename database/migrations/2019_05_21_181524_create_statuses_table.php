<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->increments('id')->comment('主キー');
            $table->integer('user_id')->unsigned();
            $table->string('song_id', 18);
            $table->integer('state')->comment('状態 [1:stacked, 2:training, 3:mastered]');
            $table->timestamp('used_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('作成・更新日時');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('song_id')->references('id')->on('songs');
            $table->unique(['user_id', 'song_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_statuses');
    }
}
