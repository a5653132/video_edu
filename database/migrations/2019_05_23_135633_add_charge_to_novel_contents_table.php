<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddChargeToNovelContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('novel_contents', function (Blueprint $table) {
            //
            $table->integer('charge')->default(0)->comment('收费');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('novel_contents', function (Blueprint $table) {
            //
            $table->dropColumn('charge');
        });
    }
}
