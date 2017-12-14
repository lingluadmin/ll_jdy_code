<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserApplyBeforeRefundTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_apply_before_refund', function (Blueprint $table) {
            $table->increments('id')->comment('申请提前赎回接口');
            $table->integer('project_id')->comment('项目id');
            $table->integer('invest_id')->comment('投资id');
            $table->integer('user_id')->comment('用户id');
            $table->decimal('cash',20,2)->unsigned()->default(0)->comment('本金');
            $table->date('end_at')->comment('项目完结日');
            $table->smallInteger('status')->default(100)->comment('状态;100:申请中; 200:赎回中; 300:已赎回');
            $table->decimal('fee',20,2)->unsigned()->default(0)->comment('手续费');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->index('user_id');
            $table->index('invest_id');
            $table->index('project_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::drop('user_apply_before_refund');
    }
}
