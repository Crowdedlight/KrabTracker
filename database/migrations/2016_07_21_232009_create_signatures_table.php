<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSignaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('signatures', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->string('sig_id');
            $table->string('type');
            $table->string('status')->default('free');
            $table->boolean('circular')->default(false);
            $table->boolean('carrier')->default(false);
            $table->integer('FK_pilot')->nullable()->length(10)->unsigned();
            $table->dateTime('startTime')->nullable();
            $table->dateTime('finishTime')->nullable();
            $table->timestamps();
        });

        Schema::table('signatures', function ($table) {
            $table->foreign('FK_pilot')->references('id')->on('users');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('signatures');
    }
}
