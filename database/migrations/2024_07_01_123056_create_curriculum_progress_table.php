<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurriculumProgressTable extends Migration
{
    public function up()
    {
        Schema::create('curriculum_progress', function (Blueprint $table) {
            $table->id(); // id
            $table->foreignId('curriculum_id');//->constrained('curriculums'); // カリキュラムid
            $table->foreignId('user_id');//->constrained('users'); // ユーザーid
            $table->boolean('clear_flg');//->default(0); // クリアフラグ
            $table->timestamps(); // 作成日時と更新日時
        });
    }

    public function down()
    {
        Schema::dropIfExists('curriculum_progress');
    }
}
