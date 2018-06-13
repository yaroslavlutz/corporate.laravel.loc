<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyToTableArticles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if( Schema::hasTable('articles') ) {  //если такая таблица существует,то
            Schema::table('articles', function (Blueprint $table) {
                /* Статьи блога будут связаны с 2-мя таблицами:
                    `users` - запись добавляется определенным пользователем Юзером
                    `articles_categories` - запись относится к определенной категории
                */
                $table->integer('user_id')->unsigned()->default(1); //поле `user_id` будет "внешним_ключом" и будет связано с полем `id` таблицы `users`
                $table->foreign('user_id')->references('id')->on('users');

                $table->integer('articles_category_id')->unsigned()->default(1); //поле `articles_category_id` будет "внешним_ключом" и будет связано с полем `id` таблицы `articles_categories`
                $table->foreign('articles_category_id')->references('id')->on('articles_categories');
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
        Schema::table('articles', function (Blueprint $table) {
            //
        });
    }
}
