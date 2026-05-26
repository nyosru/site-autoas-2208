<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdateEmailInPages extends Migration
{
    public function up()
    {
        DB::statement("
            UPDATE `pages`
            SET `html` = REPLACE(`html`, 'info@avto-as.ru', 'detali-tmn@yandex.ru')
            WHERE `module` IN ('contact', 'return', 'return2')
        ");
    }

    public function down()
    {
        DB::statement("
            UPDATE `pages`
            SET `html` = REPLACE(`html`, 'detali-tmn@yandex.ru', 'info@avto-as.ru')
            WHERE `module` IN ('contact', 'return', 'return2')
        ");
    }
}
