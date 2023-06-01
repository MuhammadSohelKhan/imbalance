<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('role')->nullable()->default('user');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();

            /*== Associated User ==*/
            $table->foreignId('created_by')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('deleted_by')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('set null');

            $table->timestamps();
            $table->softDeletes();
        });

        $sql = 'INSERT INTO `users`(`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) 
            VALUES 
            (NULL,"MASRUR BIN MORSHED","masrurbinmorshed@gmail.com","Master",NOW(),"$2y$10$enVDVB2AG1D0evG9NVRVyu4f.4f8mcOqL6aTYiazTdlIy4CExaCuC",NULL,NULL,NULL,NULL,NOW(),NOW(),NULL), 
            (NULL,"Azim Mohammad","azim_ipe@yahoo.com","superadmin",NOW(),"$2y$10$DGv.57dXwy/Dxo0.l0wLeuXk0bQgVxR.d0eIlboJzsCLtt5jgr0QG",NULL,NULL,NULL,NULL,NOW(),NOW(),NULL)'; 
                //Pass1: mBm@PT#2021; Pass2: Azim@3244 

        DB::connection()->getPdo()->exec($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
