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
            $table->integer('record_count')->default(0)->comment('登録した回数');
            $table->integer('stacked_count')->default(0)->comment('気になる曲の数');
            $table->integer('training_count')->default(0)->comment('練習中の曲の数');
            $table->integer('mastered_count')->default(0)->comment('歌える曲の数');
            $table->integer('following_count')->default(0)->comment('フォローしている数');
            $table->integer('follower_count')->default(0)->comment('フォローされている数');
            $table->text('profile_image_url')->nullable()->comment('プロフィールの画像情報');
            $table->string('email')->unique()->nullable()->comment('メールアドレス');
            $table->string('password')->comment('ログインパスワード');
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
