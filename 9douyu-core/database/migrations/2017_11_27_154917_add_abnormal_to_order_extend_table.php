<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAbnormalToOrderExtendTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_extend', function (Blueprint $table) {
            //
            $table->unsignedTinyInteger('abnormal')->comment('账户资金流水是否异常 0-正常 1-异常')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_extend', function (Blueprint $table) {
            //
        });
    }
}
