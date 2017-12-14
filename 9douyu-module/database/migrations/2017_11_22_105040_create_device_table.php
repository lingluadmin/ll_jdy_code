<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeviceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device', function(Blueprint $table)
        {
            $table->increments('id')->comment('设备激活id');
            $table->char('device_id',50)->comment('设备唯一码')->unique();
            $table->char('channel',20)->comment('渠道来源');
            $table->char('version',50)->comment('APP版本号');
            $table->char('app_request',20)->comment('请求来源');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
