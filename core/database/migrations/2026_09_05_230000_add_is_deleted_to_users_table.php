<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('users', 'is_deleted')) {
            Schema::table('users', function (Blueprint $table) {
                $table->tinyInteger('is_deleted')->default(0)->after('status');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('users', 'is_deleted')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('is_deleted');
            });
        }
    }
};
