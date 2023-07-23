<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexToAnalogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('mod_021_items_analogs', function (Blueprint $table) {
            $table->index('art_origin');
            $table->index( 'art_analog');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::table('mod_021_items_analogs', function (Blueprint $table) {
//            //
//        });
    }
}
