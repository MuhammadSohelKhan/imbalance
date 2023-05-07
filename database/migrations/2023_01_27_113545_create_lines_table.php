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
            $table->string('buyer')->nullable();
            $table->string('style')->nullable();
            $table->string('item')->nullable();
            $table->date('study_date')->nullable();
            $table->integer('floor')->nullable();
            $table->integer('line')->nullable();
            $table->integer('allowance')->nullable();
            $table->float('possible_output', 20, 10)->nullable();
            $table->integer('achieved')->nullable();
            $table->integer('imbalance')->nullable();
            $table->integer('balance')->nullable();
            $table->boolean('is_archived')->nullable()->default(0);
            $table->date('archived_date')->nullable();

            $table->foreignId('project_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('copied_from')->nullable()->constrained('lines')->onUpdate('cascade')->onDelete('set null');

            /*== Associated User ==*/
            $table->foreignId('created_by')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('deleted_by')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('set null');

            $table->softDeletes();
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
