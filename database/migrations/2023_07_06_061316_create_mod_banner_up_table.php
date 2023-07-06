<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModBannerUpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mod_banner_up', function (Blueprint $table) {
            $table->id();

            //`head` varchar(150) DEFAULT NULL,
            $table->string('head',150)->nullable()->default(NULL);
            //`img` varchar(150) DEFAULT NULL,
            $table->string('img',150)->nullable()->default(NULL);
            //`link` varchar(150) DEFAULT NULL,
            $table->string('link',150)->nullable()->default(NULL);

            //`add_dt` datetime DEFAULT NULL,
            //`add_who` int(9) DEFAULT NULL,
            $table->dateTime('add_dt')->nullable()->default(NULL);
            $table->integer('add_who')->nullable()->default(NULL);
            //`sort` int(2) NOT NULL DEFAULT '50',
            //`status` set('show','hide','delete') NOT NULL DEFAULT 'show'
            $table->tinyInteger('sort')->default(50 );
            $table->set('status',['show','hide','delete'])->default('show' );

            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mod_banner_up');
    }
}
