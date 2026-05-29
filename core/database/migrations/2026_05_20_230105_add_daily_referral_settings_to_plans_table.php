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
        Schema::table('plans', function (Blueprint $table) {
            $table->dateTime('daily_referral_start_time')->nullable()->after('daily_referral_enabled');
            $table->boolean('daily_referral_exclude_weekends')->default(0)->after('daily_referral_start_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn(['daily_referral_start_time', 'daily_referral_exclude_weekends']);
        });
    }
};
