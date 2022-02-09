<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('name_kana')->nullable();
            $table->integer('rank')->nullable();
            $table->string('office_address')->nullable();
            $table->string('office_address_code')->nullable();
            $table->string('office_tel')->nullable();
            $table->string('office_fax')->nullable();
            $table->string('place_address')->nullable();
            $table->string('place_address_code')->nullable();
            $table->string('place_tel')->nullable();
            $table->string('place_fax')->nullable();
            $table->integer('sales_channel')->nullable();
            $table->string('sales_channel_company_name')->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('clients');
    }
}
