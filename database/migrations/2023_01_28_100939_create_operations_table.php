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
            $table->float('average_cycle_time', 20, 10)->nullable();
            $table->float('cycle_time_with_allowance', 20, 10)->nullable();
            $table->tinyInteger('allocated_man_power')->nullable();
            $table->float('dedicated_cycle_time', 20, 10)->nullable();
            $table->float('capacity_per_hour', 20, 10)->nullable();
            $table->float('minutes_lost_per_hour', 20, 10)->nullable();
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
