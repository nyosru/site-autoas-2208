<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGmUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('gm_user'))
        Schema::create('gm_user', function (Blueprint $table) {
            $table->id();


            // CREATE TABLE `gm_user` (
            //     `id` int(11) NOT NULL,
            //     `login` varchar(150) DEFAULT NULL,
            $table->string('login',150)->nullable()->default(NULL);
            //     `pass` varchar(100) DEFAULT NULL,
            $table->string('pass',150)->nullable()->default(NULL);
            //     `pass5` varchar(40) DEFAULT NULL,
            $table->string('pass5',40)->nullable()->default(NULL);
            //     `folder` varchar(150) DEFAULT NULL,
            $table->string('folder',150)->nullable()->default(NULL);
            //     `mail` varchar(150) DEFAULT NULL,
            $table->string('mailv',150)->nullable()->default(NULL);
            //     `mail_confirm` varchar(150) DEFAULT NULL,
            $table->string('mail_confirm',150)->nullable()->default(NULL);
            //     `name` varchar(150) DEFAULT NULL,
            $table->string('name',150)->nullable()->default(NULL);
            //     `soname` varchar(150) DEFAULT NULL,
            $table->string('soname',150)->nullable()->default(NULL);
            //     `family` varchar(150) DEFAULT NULL,
            $table->string('family',150)->nullable()->default(NULL);
            //     `phone` varchar(20) DEFAULT NULL,
            $table->string('phone',20)->nullable()->default(NULL);
            //     `avatar` varchar(250) DEFAULT NULL,
            $table->string('avatar',250)->nullable()->default(NULL);
            //     `adres` varchar(250) DEFAULT NULL,
            $table->string('adres',250)->nullable()->default(NULL);
            //     `about` text,
            $table->text('about')->nullable()->default(NULL);
            //     `soc_web` varchar(50) DEFAULT NULL,
            $table->string('soc_web',50)->nullable()->default(NULL);
            //     `soc_web_link` varchar(250) DEFAULT NULL,
            $table->string('soc_web_link',250)->nullable()->default(NULL);
            //     `soc_web_id` varchar(250) DEFAULT NULL,
            $table->string('soc_web_id',250)->nullable()->default(NULL);
            //     `access` varchar(50) DEFAULT NULL,
            $table->string('access',50)->nullable()->default(NULL);
            //     `status` varchar(50) NOT NULL DEFAULT 'new',
            $table->string('status',50)->default('new');
            //     `admin_status` varchar(250) DEFAULT NULL,
            $table->string('admin_status',250)->nullable()->default(NULL);
            //     `dt` int(11) DEFAULT NULL,
            $table->integer('dt')->nullable()->default(NULL);
            //     `ip` varchar(20) DEFAULT NULL,
            $table->string('ip',20)->nullable()->default(NULL);
            //     `city` varchar(150) DEFAULT NULL,
            $table->string('city',150)->nullable()->default(NULL);
            //     `city_name` varchar(150) DEFAULT NULL,
            $table->string('city_name',150)->nullable()->default(NULL);
            //     `points` int(11) NOT NULL DEFAULT '0',
            $table->integer('points')->default(0);
            //     `country` varchar(150) DEFAULT NULL,
            $table->string('country',150)->nullable()->default(NULL);
            //     `recovery` varchar(50) DEFAULT NULL,
            $table->string('recovery',50)->nullable()->default(NULL);
            //     `recovery_dt` timestamp NULL DEFAULT NULL
            //   ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
        Schema::dropIfExists('gm_user');
    }
}
