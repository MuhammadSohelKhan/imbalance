<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lines', function (Blueprint $table) {
            $table->id();
            $table->integer('floor')->nullable();
            $table->integer('line')->nullable();
            $table->integer('allowance')->nullable();
            $table->integer('possible_output')->nullable();
            $table->integer('achieved')->nullable();
            $table->integer('imbalance')->nullable();
            $table->integer('balance')->nullable();
            $table->foreignId('summary_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('lines');
    }
}
