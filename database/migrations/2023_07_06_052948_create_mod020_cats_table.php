<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMod020CatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mod_020_cats', function (Blueprint $table) {
            $table->id();

            $table->string('head',150)->nullable()->default(NULL);
            $table->string('a_id',150)->nullable()->default(NULL);
            $table->string('a_parentid',150)->nullable()->default(NULL);

            $table->dateTime('add_dt')->nullable()->default(NULL);
            $table->integer('add_who')->nullable()->default(NULL);

            $table->tinyInteger('sort')->default(50 );
            $table->set('status',['show','hide','delete'])->default('show' );

//            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mod_020_cats');
    }
}
