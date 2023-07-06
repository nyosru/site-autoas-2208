<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMod022OrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mod_022_orders', function (Blueprint $table) {
            $table->id();

            //`i_name` varchar(250) DEFAULT NULL,
            $table->string('i_name',150)->nullable()->default(NULL);
            //`id` int(11) NOT NULL,
            //`name` varchar(150) DEFAULT NULL,
            $table->string('name',150)->nullable()->default(NULL);
            //`user_id` varchar(150) DEFAULT NULL,
            $table->string('user_id',150)->nullable()->default(NULL);
            //`user_name` varchar(150) DEFAULT NULL,
            $table->string('user_name',150)->nullable()->default(NULL);
            //`user_tel` varchar(150) DEFAULT NULL,
            $table->string('user_tel',150)->nullable()->default(NULL);
            //`user_soc` varchar(150) DEFAULT NULL,
            $table->string('user_soc',150)->nullable()->default(NULL);
            //`user_soc_id` varchar(150) DEFAULT NULL,
            $table->string('user_soc_id',150)->nullable()->default(NULL);
            //`item` varchar(150) DEFAULT NULL,
            $table->string('item',150)->nullable()->default(NULL);
            //`price` varchar(150) DEFAULT NULL,
            $table->string('price',150)->nullable()->default(NULL);
            //`kolvo` varchar(150) DEFAULT NULL,
            $table->string('kolvo',150)->nullable()->default(NULL);

            //`add_dt` datetime DEFAULT NULL,
            //`add_who` int(9) DEFAULT NULL,
            $table->dateTime('add_dt')->nullable()->default(NULL);
            $table->integer('add_who')->nullable()->default(NULL);
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
        Schema::dropIfExists('mod_022_orders');
    }
}
