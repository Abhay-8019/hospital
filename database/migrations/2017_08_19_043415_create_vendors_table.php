<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->nullable();
            $table->string('vendor_code', 150);
            $table->string('name', 150);
            $table->string('company_name', 150);
            $table->text('company_address')->nullable();
            $table->string('company_phone', 15)->nullable();
            $table->string('mobile', 11)->nullable();

            $table->string('contact_number', 11)->nullable();
            $table->string('email', 70)->unique()->nullable();
            $table->string('bank_name', 200)->nullable();
            $table->string('branch_name', 150)->nullable();
            $table->string('account_number', 150)->nullable();
            $table->string('ifsc_code', 50)->nullable();
            $table->string('country', 100)->nullable();
            $table->string('state', 70)->nullable();
            $table->string('city', 70)->nullable();
            $table->string('zip_code', 11)->nullable();
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
        Schema::dropIfExists('vendor');
    }
}
