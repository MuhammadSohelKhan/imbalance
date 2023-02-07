<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operations', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->string('machine')->nullable();
            $table->float('average_cycle_time')->nullable();
            $table->float('cycle_time_with_allowance')->nullable();
            $table->tinyInteger('allocated_man_power')->nullable();
            $table->float('dedicated_cycle_time')->nullable();
            $table->float('capacity_per_hour')->nullable();
            $table->float('minutes_lost_per_hour')->nullable();
            $table->foreignId('line_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('operations');
    }
}
