<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlantingScheduleDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planting_schedule_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('planting_schedule_id');
            $table->string('activity');
            $table->mediumText('information')->nullable();
            $table->date('date');
            $table->boolean('is_done')->default(false);

            $table->foreign('planting_schedule_id')->references('id')->on('planting_schedules')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('planting_schedule_details');
    }
}
