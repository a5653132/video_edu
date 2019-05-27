<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddChargeToUserNovelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_novel', function (Blueprint $table) {
            //
            $table->integer('charge')->default(0)->comment('价格')->after('novel_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_novel', function (Blueprint $table) {
            //
            $table->dropIfExists('charge');
        });
    }
}
