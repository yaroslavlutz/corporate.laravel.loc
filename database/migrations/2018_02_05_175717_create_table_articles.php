<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableArticles extends Migration
{
    /** Run the migrations.
     * @return void
    */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) { //Можно сразу к создаваемым ячейкам применять какие-то default-значения: $table->text('text')->default('some text..');
            //$table->engine = 'InnoDB'; //можно явно указать какой движок будет использоваться для табл.если не указывать, то использунтся движок,выбранный для БД вцелом
            $table->increments('id'); //это значит поле `id` INT AUTO_INCREMENT PPIMARY KEY
            $table->string('alias',100)->unique(); //varchar длинной 100 символов, уникальное поле //псевдоним для статьи(slug) - ее alias(название)
            $table->string('title',150); //varchar длинной 150 символов //Это заголовок для статьи
            $table->text('desctext');  //Text длинной неограничено  //Это для короткого(preview) текста(текст-описание) статьи
            $table->text('fulltext');  //Text длинной неограничено  //Это для полного текста статьи
            $table->string('images',255);  //varchar длинной 255 символов //Это для хранения картинки(изображения/баннера) в виде ссылки(ок) для статьи
            $table->timestamps(); //для записи времени создания или изменения соответствующей записи в БД
        });
    }

    /** Reverse the migrations.
     * @return void
    */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
