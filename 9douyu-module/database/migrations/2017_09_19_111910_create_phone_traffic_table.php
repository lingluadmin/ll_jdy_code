<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhoneTrafficTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phone_traffic', function (Blueprint $table) {
            $table->increments('id')->comment('流量话费充值记录表');
            $table->string('order_id', 32)->default('')->unique()->comment('订单号');
            $table->integer('user_id')->index()->default('0')->comment('用户Id');
            $table->char('phone',15)->comment('手机号');
            $table->decimal('pack_price', 20, 2)->unsigned()->default(0)->comment('充值额度，流量为Mb,话费为元');
            $table->decimal('discount', 4, 2)->unsigned()->default('0.00')->comment('充值的折扣');
            $table->decimal('cost_money', 20, 2)->unsigned()->default('0.00')->comment('实际消费金额');
            $table->tinyInteger('type')->unsigned()->default(1)->comment('订单类型：1-流量订单，2-话费订单');
            $table->smallInteger('status')->unsigned()->default(300)->comment('订单状态：200-成功，300-处理中，401-充值超时,500-失败');
            $table->integer('source')->unsigned()->default(0)->comment('来源，0为系统参照note')->index();
            $table->char('note')->comment('充值备注说明');
            $table->char('status_note')->comment('接口状态');
            $table->timestamp('handle_time')->default('0000-00-00 00:00:00');
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
