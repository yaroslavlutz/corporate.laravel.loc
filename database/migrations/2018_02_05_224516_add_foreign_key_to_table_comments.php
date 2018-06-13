<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyToTableComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if( Schema::hasTable('comments') ) {  //если такая таблица существует,то
            Schema::table('comments', function (Blueprint $table) {
                /* Комментарии будут связаны с 2-мя таблицами:
                        `users` - комментарий добавляется определенным пользователем Юзером(зарегистрированным). Комментарии могут оставлять и не зарегистрирован. пользоват.,-так вот эта связь для зарегинных
                        `articles` - комментарий относится к определенной статье
                */
                $table->integer('user_id')->unsigned()->nullable(); //поле `user_id` будет "внешним_ключом" и будет связано с полем `id` таблицы `users`
                $table->foreign('user_id')->references('id')->on('users');

                $table->integer('article_id')->unsigned()->default(1);  //поле `article_id` будет "внешним_ключом" и будет связано с полем `id` таблицы `articles`
                $table->foreign('article_id')->references('id')->on('articles');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            //
        });
    }
}
