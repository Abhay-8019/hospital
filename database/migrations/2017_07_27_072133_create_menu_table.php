<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->increments('id');
//            $table->integer('hospital_id');
            $table->string('name', 50);
            $table->string('route', 50)->nullable();
            $table->string('icon', 50)->nullable();
            $table->integer('parent_id')->nullable();
            $table->tinyInteger('is_in_menu')->default(0);
            $table->tinyInteger('quick_menu')->default(0);
            $table->string('dependent_routes', 255)->nullable();
            $table->tinyInteger('is_common')->nullable();
            $table->tinyInteger('for_devs')->default(0);
            $table->tinyInteger('has_child')->default(0);
            $table->integer('_order')->nullable();
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
        Schema::dropIfExists('menu');
    }
}
