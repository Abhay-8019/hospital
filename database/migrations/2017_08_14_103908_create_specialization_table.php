<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecializationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('specialization',function(Blueprint $table){
         $table->increments('id');
           $table->integer('company_id')->nullable();
           $table->string('name');
           $table->tinyInteger('status');
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
        Schema::dropIFExists('specialization');
    }
}
