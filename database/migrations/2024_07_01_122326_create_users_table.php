<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // id
            $table->string('name'); // ユーザーネーム
            $table->string('name_kana'); // ユーザーネーム カナ
            $table->string('email')->unique(); // メールアドレス
            $table->string('password'); // パスワード
            $table->string('profile_image')->nullable(); // プロフィール画像
            $table->foreignId('grade_id');// クラスID
            //->constrained('grades'); 
            $table->timestamps(); //作成日と更新日
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
