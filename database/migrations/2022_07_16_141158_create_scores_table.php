<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->id();
            $table->string('admin_name');
            $table->unsignedBigInteger('admin_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('submission_id');
            $table->integer('user_score');
            $table->text('note_for_user')->default('Tidak Ada Catatan');
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
        Schema::dropIfExists('scores');
    }
}
