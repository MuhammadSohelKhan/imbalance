<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('client_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('project_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['client_id','project_id','assigned_to']);
        });
    }
}
