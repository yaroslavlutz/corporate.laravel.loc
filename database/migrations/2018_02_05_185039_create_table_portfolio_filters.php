<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePortfolioFilters extends Migration
{
    /** Run the migrations.
     * @return void
    */
    public function up()
    {
        Schema::create('portfolio_filters', function (Blueprint $table) { //Можно сразу к создаваемым ячейкам применять какие-то default-значения: $table->text('text')->default('some text..');
            //$table->engine = 'InnoDB'; //можно явно указать какой движок будет использоваться для табл.если не указывать, то использунтся движок,выбранный для БД вцелом
            $table->increments('id'); //это значит поле `id` INT AUTO_INCREMENT PPIMARY KEY
            $table->string('alias',100)->unique(); //varchar длинной 100 символов, уникальное поле //псевдоним для фильтра портфолио(slug) - его alias(название)фильтра
            $table->string('title',100); //varchar длинной 100 символов //Это заголовок(имя) для для фильтра портфолио
            $table->timestamps(); //для записи времени создания или изменения соответствующей записи в БД
        });
    }

    /** Reverse the migrations.
     * @return void
    */
    public function down()
    {
        Schema::dropIfExists('portfolio_filters');
    }
}
