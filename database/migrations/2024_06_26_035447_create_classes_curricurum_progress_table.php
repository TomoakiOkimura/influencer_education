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
        Schema::create('classes_curricurum_progress', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('curriculums_id');
            $table->bigInteger('users_id');
            $table->boolean('clear_flg')->nullable;

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
        Schema::dropIfExists('classes_curricurum_progress');
    }
};
