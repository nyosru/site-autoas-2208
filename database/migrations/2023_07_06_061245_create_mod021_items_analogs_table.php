<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMod021ItemsAnalogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('mod_021_items_analogs'))
        Schema::create('mod_021_items_analogs', function (Blueprint $table) {
            $table->id();

            //`art_origin` varchar(150) DEFAULT NULL,
            $table->string('art_origin',150)->nullable()->default(NULL);
            //`art_analog` varchar(150) DEFAULT NULL,
            $table->string('art_analog',150)->nullable()->default(NULL);

            //`sort` int(2) NOT NULL DEFAULT '50',
            //`status` set('show','hide','delete') NOT NULL DEFAULT 'show'
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
        Schema::dropIfExists('mod_021_items_analogs');
    }
}
