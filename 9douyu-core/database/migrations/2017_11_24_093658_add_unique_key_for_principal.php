<?php
/**
 * created By vim
 * User: linguanghui
 * Date: 2017-11-27
 * Desc: 为core活期和定期表创建user_id唯一索引
 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUniqueKeyForPrincipal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //add unique for current_principal
        Schema::table('current_principal', function (Blueprint $table) {
            $table->unique('user_id');
        });
        //add unique for term_principal
        Schema::table('term_principal', function (Blueprint $table) {
            $table->unique('user_id');
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
