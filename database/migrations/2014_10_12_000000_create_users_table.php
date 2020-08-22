<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->integer('company_id')->default(0);
            $table->integer('doctor_id')->nullable();
            $table->integer('patient_id')->nullable();
            $table->integer('staff_id')->nullable();
            $table->integer('role_id')->default(0);
            $table->string('name')->nullable();
            $table->string('username');
            $table->string('email', 70)->unique()->nullable();
            $table->string('password', 60);
            $table->tinyInteger('is_super_admin')->default(0);
            $table->tinyInteger('is_admin')->default(0);
            $table->boolean('status')->default(1);
            $table->rememberToken();
            $table->tinyInteger('otp')->default(0);
            $table->string('forgot_otp', 10)->nullable();
            $table->datetime('last_login')->nullable();
            $table->datetime('login_attempts')->nullable();
            $table->tinyInteger('is_reset_password')->default(0);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
//            $table->tinyInteger('user_type')->default(1)->comment('1 => doctor,  2 => patient');
//            $table->tinyInteger('is_default')->default(0);
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
