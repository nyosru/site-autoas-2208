<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleAndVkToUsersTable extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('users', 'vk_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('vk_id')->nullable()->unique()->after('email');
            });
        }
        if (!Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('tourist')->after('remember_token');
            });
        }
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'vk_id')) {
                $table->dropColumn('vk_id');
            }
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
}
