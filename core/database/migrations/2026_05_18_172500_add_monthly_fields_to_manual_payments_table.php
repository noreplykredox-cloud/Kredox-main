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
        Schema::table('manual_payments', function (Blueprint $table) {
            $table->unsignedTinyInteger('exclude_weekends')->default(0)->after('monthly_day');
            $table->string('selected_month', 10)->nullable()->after('exclude_weekends');
            $table->decimal('monthly_percentage', 11, 8)->nullable()->after('selected_month');
            // Change percentage column to decimal(11, 8) to allow precise daily percentage calculations
            $table->decimal('percentage', 11, 8)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('manual_payments', function (Blueprint $table) {
            $table->dropColumn(['exclude_weekends', 'selected_month', 'monthly_percentage']);
            $table->decimal('percentage', 5, 2)->change();
        });
    }
};
