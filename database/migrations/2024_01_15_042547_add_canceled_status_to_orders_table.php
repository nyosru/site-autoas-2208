<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddCanceledStatusToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(' ALTER TABLE `orders` DROP `status`; ');
        DB::statement("ALTER TABLE `orders` ADD `status` ENUM('new','start','maked','sended','finish','canceled') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new' COMMENT 'new22 новый /\r\n start принят в работу, собираем /\r\n maked собран /\r\n sended отправлен /\r\n finish заказ получен, выполнен, закрыт /\r\n canceled отменён';");

//        Schema::table('orders', function (Blueprint $table) {
//            // Для отмены изменений, если это необходимо
//            $table->dropColumn('status');
//        });
//        Schema::table('orders', function (Blueprint $table) {
//            $table->enum('status', [
//                'new',
//                'start',
//                'maked',
//                'sended',
//                'finish',
//                'canceled'  // Добавляем новое значение 'canceled'
//            ])->default('new')->comment('new новый /
//            start принят в работу, собираем /
//            maked собран /
//            sended отправлен /
//            finish заказ получен, выполнен, закрыт /
//            canceled отменён'); // Обновите комментарий, если необходимо
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
