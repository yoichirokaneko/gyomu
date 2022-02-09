<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepairFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repair_files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('activity_history_id')->unsigned()->index();
            $table->string('path')->unique();
            $table->timestamps();

            $table->foreign('activity_history_id')->references('id')->on('activity_histories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('repair_files');
    }
}
