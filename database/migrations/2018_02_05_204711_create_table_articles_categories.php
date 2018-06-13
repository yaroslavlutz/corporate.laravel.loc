<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableArticlesCategories extends Migration
{
    /** Run the migrations.
     * @return void
    */
    public function up()
    {
        Schema::create('articles_categories', function (Blueprint $table) { //Можно сразу к создаваемым ячейкам применять какие-то default-значения: $table->text('text')->default('some text..');
            //$table->engine = 'InnoDB'; //можно явно указать какой движок будет использоваться для табл.если не указывать, то использунтся движок,выбранный для БД вцелом
            $table->increments('id'); //это значит поле `id` INT AUTO_INCREMENT PPIMARY KEY
            $table->integer('parent_cat_id')->default(0); //это ID родительской категории если у нас есть подкатегория(ии). Зн-е по-умолчанию  = нуль
            $table->string('title',100); //varchar длинной 100 символов //заголовок(наименование) категории
            $table->string('alias',100)->unique(); //varchar длинной 100 символов, уникальное поле //псевдоним для категории(slug) - ее alias(название)
            $table->timestamps(); //для записи времени создания или изменения соответствующей записи в БД
        });
    }

    /** Reverse the migrations.
     * @return void
    */
    public function down()
    {
        Schema::dropIfExists('articles_categories');
    }
}
