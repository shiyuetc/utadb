<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->comment('主キー');
            $table->string('screen_name', 15)->unique()->comment('ユーザー識別用ID');
            $table->string('name', 20)->comment('ユーザー名');
            $table->string('description', 255)->nullable()->comment('紹介文');
            $table->integer('stacked_state_count')->default(0)->comment('気になる曲の数');
            $table->integer('training_state_count')->default(0)->comment('練習中の曲の数');
            $table->integer('mastered_state_count')->default(0)->comment('歌える曲の数');
            $table->text('profile_image_url')->nullable()->comment('プロフィール画像のURL');
            $table->string('email')->unique()->nullable()->comment('メールアドレス');
            $table->string('password')->comment('ログインパスワード');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
