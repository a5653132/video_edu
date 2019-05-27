<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNovelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('novels', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('title')->comment('名');
            $table->string('slug')->comment('slug链接');
            $table->string('thumb')->comment('封面');
            $table->integer('charge')->default(0)->comment('收费');
            $table->string('short_description')->default('')->comment('简短介绍');
            $table->text('description')->comment('小说介绍');
            $table->string('seo_keywords')->default('')->comment('SEO关键字');
            $table->string('seo_description')->default('')->comment('SEO描述');
            $table->timestamp('published_at')->default(null)->nullable(true)->comment('上线时间');
            $table->tinyInteger('is_show')->comment('1显示,-1隐藏');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('novels');
    }
}
