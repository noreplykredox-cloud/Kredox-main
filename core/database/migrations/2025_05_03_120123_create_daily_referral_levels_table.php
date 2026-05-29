<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_referral_levels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plan_id');
            $table->unsignedInteger('level');
            $table->decimal('percentage', 5, 2)->default(0.00)->comment('Percentage to give at this level');
            $table->timestamps();

            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');
        });

        Schema::table('plans', function (Blueprint $table) {
            $table->boolean('daily_referral_enabled')->default(0)->after('referral_bonus')
                  ->comment('Enable daily referral payout');
        });
    }

    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn('daily_referral_enabled');
        });

        Schema::dropIfExists('daily_referral_levels');
    }
};