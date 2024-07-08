<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classes_clear_checks', function (Blueprint $table) {
            $table->id(); // 自動インクリメントのプライマリキー
            $table->unsignedBigInteger('user_id'); // ユーザーID
            $table->unsignedBigInteger('grade_id'); // グレードID
            $table->tinyInteger('clear_fig'); // クリアフィギュア
            $table->timestamps(); // 作成日時と更新日時
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classes_clear_checks');
    }
};
