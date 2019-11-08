<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('doubleStudent_id')->unsigned();
            $table->integer('petition_id')->unsigned();
            $table->integer('petitionFirst')->nullable();
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('petition_id')->references('id')->on('petitions');
            $table->foreign('doubleStudent_id')->references('id')->on('double_students');
            $table->primary(['user_id', 'doubleStudent_id', 'petition_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('records');
    }
}
