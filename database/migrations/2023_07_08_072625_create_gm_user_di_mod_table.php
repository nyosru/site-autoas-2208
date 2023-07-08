<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGmUserDiModTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('gm_user_di_mod'))
        Schema::create('gm_user_di_mod', function (Blueprint $table) {
            $table->id();

            //CREATE TABLE `gm_user_di_mod` (
            //`id` int(11) NOT NULL,
            //`user_id` int(7) NOT NULL,
            $table->integer('user_id');
            //`folder` varchar(100) NOT NULL,
            $table->string('folder',100);
            //`module` varchar(100) NOT NULL,
            $table->string('module',100);
            //`status` varchar(20) NOT NULL DEFAULT 'yes',
            $table->string('status',20)->default('yes');
            //`mode` varchar(10) NOT NULL
            $table->string('mode',10);
            //) ENGINE=InnoDB DEFAULT CHARSET=utf8;


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gm_user_di_mod');
    }
}
