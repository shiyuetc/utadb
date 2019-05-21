<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('songs', function (Blueprint $table) {
            $table->string('id', 18)->comment('主キー');
            $table->string('title', 255)->comment('タイトル');
            $table->string('artist_id', 16)->comment('アーティストID');
            $table->string('artist', 255)->comment('アーティスト名');
            $table->text('image_url')->nullable()->comment('カバー画像のURL');
            $table->text('audio_url')->nullable()->comment('サンプル音源のURL');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('songs');
    }
}
