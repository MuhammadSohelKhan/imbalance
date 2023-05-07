<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->date('start_date')->nullable();
            $table->date('renew_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('assigned_officer')->nullable();
            $table->boolean('is_active')->nullable()->default(0);
            $table->longText('present_situation')->nullable();
            $table->longText('goal')->nullable();

            $table->foreignId('client_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('projects');
    }
}
