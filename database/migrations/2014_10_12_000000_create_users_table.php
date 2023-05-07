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
            $table->timestamps();
        });

        $sql = 'INSERT INTO `users`(`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (NULL,"MASRUR BIN MORSHED","masrurbinmorshed@gmail.com","Master",NOW(),"$2y$10$enVDVB2AG1D0evG9NVRVyu4f.4f8mcOqL6aTYiazTdlIy4CExaCuC",NULL,NOW(),NOW()), (NULL,"Azim Mohammad","azim_ipe@yahoo.com","superadmin",NOW(),"$2y$10$DGv.57dXwy/Dxo0.l0wLeuXk0bQgVxR.d0eIlboJzsCLtt5jgr0QG",NULL,NOW(),NOW())'; //Pass1: mBm@PT#2021; Pass2: Azim@3244 
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
