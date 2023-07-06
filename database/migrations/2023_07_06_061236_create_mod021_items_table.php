<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMod021ItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mod_021_items', function (Blueprint $table) {
            $table->id();


            //
            //CREATE TABLE `mod_021_items` (
            //`country` varchar(250) DEFAULT NULL,
            $table->string('country',150)->nullable()->default(NULL);
            //`manufacturer` varchar(250) DEFAULT NULL,
            $table->string('manufacturer',150)->nullable()->default(NULL);
            //`comment` text,
            $table->text('comment',150)->nullable()->default(NULL);
            //`id` int(11) NOT NULL,
            //`head` varchar(150) DEFAULT NULL,
            $table->string('head',150)->nullable()->default(NULL);
            //`a_id` varchar(150) DEFAULT NULL,
            $table->string('a_id',150)->nullable()->default(NULL);
            //`a_categoryid` varchar(150) DEFAULT NULL,
            $table->string('a_categoryid',150)->nullable()->default(NULL);
            //`a_catnumber` varchar(150) DEFAULT NULL,
            $table->string('a_catnumber',150)->nullable()->default(NULL);
            //`catnumber_search` varchar(150) DEFAULT NULL,
            $table->string('catnumber_search',150)->nullable()->default(NULL);
            //`a_price` varchar(150) DEFAULT NULL,
            $table->string('a_price',150)->nullable()->default(NULL);
            //`a_in_stock` varchar(150) DEFAULT NULL,
            $table->string('a_in_stock',150)->nullable()->default(NULL);
            //`a_arrayimage` varchar(150) DEFAULT NULL,
            $table->string('a_arrayimage',150)->nullable()->default(NULL);
            //`add_dt` datetime DEFAULT NULL,
            //`add_who` int(9) DEFAULT NULL,
            $table->dateTime('add_dt')->nullable()->default(NULL);
            $table->integer('add_who')->nullable()->default(NULL);
            //`sort` int(2) NOT NULL DEFAULT '50',
            //`status` set('show','hide','delete') NOT NULL DEFAULT 'show'
            $table->tinyInteger('sort')->default(50 );
            $table->set('status',['show','hide','delete'])->default('show' );
            //) ENGINE=InnoDB DEFAULT CHARSET=utf8;

//            $table->string('id_cat',150)->nullable()->default(NULL);
//            $table->string('icon',150)->nullable()->default(NULL);
//
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
        Schema::dropIfExists('mod_021_items');
    }
}
