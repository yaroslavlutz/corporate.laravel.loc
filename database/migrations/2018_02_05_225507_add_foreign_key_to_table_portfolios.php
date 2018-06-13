<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyToTablePortfolios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if( Schema::hasTable('portfolios') ) {  //если такая таблица существует,то
            Schema::table('portfolios', function (Blueprint $table) {
                /* Портфолио будет связана с 1 таблицей:
                    `portfolio_filters` - каждое портфолио(каждая работа) привязана(относится) к определенному фильтру(по сути как категория). Но тут мы фильдеперцнули и связь делаем не по
                                          полю ID табл.`portfolio_filters`, а по полю `alias`, которое у нас типа "string", поэтому для связи делаем поле с типом "string" тоже
                */
                $table->string('portfolio_filter_alias'); //поле `portfolio_filter_alias` будет "внешним_ключом" и будет связано с полем `alias` таблицы `portfolio_filters`
                $table->foreign('portfolio_filter_alias')->references('alias')->on('portfolio_filters');
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
        Schema::table('portfolios', function (Blueprint $table) {
            //
        });
    }
}
