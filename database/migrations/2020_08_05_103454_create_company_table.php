<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
  public function up()
    {
        Schema::create('company', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_logo', 255)->nullable();
            $table->string('company_code', 50);
            $table->string('company_name', 100);
            $table->integer('company_building', 11)->nullable();
            $table->string('contact_person', 100);
            $table->string('tin_number', 15)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('email1', 50)->nullable();
            $table->string('mobile', 50)->nullable();
            $table->string('mobile1', 50)->nullable();
            $table->string('phone', 15)->nullable();
            $table->string('website', 50)->nullable();
            $table->string('permanent_address')->nullable();
            $table->string('correspondence_address')->nullable();
            $table->string('country', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('pincode', 10)->nullable();
            $table->integer('timezone')->nullable();
            $table->boolean('status')->default(1);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
//        $table->string('brand_name', 100)->nullable();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company');