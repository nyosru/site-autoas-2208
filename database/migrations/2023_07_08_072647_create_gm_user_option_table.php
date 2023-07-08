<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGmUserOptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gm_user_option', function (Blueprint $table) {
            $table->id();

            //CREATE TABLE `gm_user_option` (
            //`id` int(11) NOT NULL,
            //`user` int(7) NOT NULL,
            $table->integer('user');
            //`project` int(7) NOT NULL,
            $table->integer('project');
            //`option` varchar(50) DEFAULT NULL,
            $table->string('option', 50)->nullable()->default(NULL);
            //`value` varchar(250) DEFAULT NULL,
            $table->string('value', 250)->nullable()->default(NULL);
            //`val1` varchar(150) DEFAULT NULL,
            $table->string('val1', 150)->nullable()->default(NULL);
            //`val2` varchar(150) DEFAULT NULL,
            $table->string('val2', 150)->nullable()->default(NULL);
            //`val3` varchar(150) DEFAULT NULL,
            $table->string('val3', 150)->nullable()->default(NULL);
            //`val4` varchar(150) DEFAULT NULL,
            $table->string('val4', 150)->nullable()->default(NULL);
            //`val5` varchar(150) DEFAULT NULL
            $table->string('val5', 150)->nullable()->default(NULL);
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
        Schema::dropIfExists('gm_user_option');
    }
}
