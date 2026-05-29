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
              $table->enum('frequency', ['daily', 'monthly'])->default('daily');
              $table->unsignedTinyInteger('monthly_day')->nullable()->comment('1 to 30, used only when frequency is monthly');
          });
      }

      public function down()
      {
          Schema::table('manual_payments', function (Blueprint $table) {
              $table->dropColumn(['frequency', 'monthly_day']);
          });
      }
};
