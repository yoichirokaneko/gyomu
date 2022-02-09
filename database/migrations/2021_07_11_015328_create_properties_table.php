<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned()->index();
            $table->integer('activity_history_id')->unsigned()->index();
            $table->integer('status')->nullable();
            $table->integer('pic_id')->unsigned()->index()->nullable();
            $table->integer('reason')->nullable();
            $table->integer('sales_staff_id')->unsigned()->index()->nullable();
            $table->string('model')->nullable();
            $table->date('introduction_date')->nullable();
            $table->text('note')->nullable();
            $table->date('answer_date')->nullable();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('activity_history_id')->references('id')->on('activity_histories')->onDelete('cascade');
            $table->foreign('pic_id')->references('id')->on('pics');
            $table->foreign('sales_staff_id')->references('id')->on('sales_staff');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('properties');
    }
}
