<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldProject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('project', function (Blueprint $table) {
            $table->unsignedTinyInteger('is_credit_assign')->comment('是否可转让 0-不可转让 1-可转让')->default(1);
            $table->unsignedSmallInteger('assign_keep_days')->comment('持有天数')->default(30);
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
