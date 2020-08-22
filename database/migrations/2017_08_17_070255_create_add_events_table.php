<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('add_events', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->integer('event_type_id')->nullable();
            $table->integer('department_id')->nullable();
            $table->string('event_name', 150);
            $table->string('event_code', 100)->nullable();
            $table->tinyInteger('is_holiday')->nullable();
            $table->dateTime('event_start');
            $table->dateTime('event_end');
            $table->text('event_description');
            $table->tinyInteger('event_for')->comment('1 => Common To All,  2 => Select Department');
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
        Schema::dropIfExists('add_events');
    }
}
