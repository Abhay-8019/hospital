<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaffRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_registrations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->integer('user_id')->nullable();
            $table->integer('role_id');
            $table->integer('department_id');
            $table->integer('designation_id');
            $table->string('register_number', 150);
            $table->string('image')->nullable();
            $table->string('first_name', 70);
            $table->string('last_name', 70);
            $table->tinyInteger('gender')->comment('1 => Male,  2 => Female');
            $table->dateTime('dob')->nullable();
            $table->tinyInteger('blood_group')->comment('1 => A+, 2 => A-, 3 => B+, 4 => B-, 5 => AB+, 6 => AB-, 7 => O+, 8 => O-');
            $table->text('address')->nullable();
            $table->string('email', 70)->unique()->nullable();
            $table->string('contact_number', 11)->nullable();

            $table->dateTime('do_joining');
            $table->dateTime('do_relieving')->nullable();
            $table->dateTime('do_retirement')->nullable();

            $table->string('e_name', 70)->nullable();
            $table->string('e_contact_number', 11)->nullable();
            $table->string('relationship', 70)->nullable();

            $table->string('reference_person', 70)->nullable();
            $table->string('reference_contact', 11)->nullable();

            $table->string('q_name', 70)->nullable();
            $table->text('q_address')->nullable();
            $table->string('qualification', 70)->nullable();


            $table->boolean('status')->default(1);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staff_registrations');
    }
}
