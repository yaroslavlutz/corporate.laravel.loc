<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSliders extends Migration
{
    /** Run the migrations.
     * @return void
    */
    public function up()
    {
        Schema::create('sliders', function (Blueprint $table) { //Можно сразу к создаваемым ячейкам применять какие-то default-значения: $table->text('text')->default('some text..');
            //$table->engine = 'InnoDB'; //можно явно указать какой движок будет использоваться для табл.если не указывать, то использунтся движок,выбранный для БД вцелом
            $table->increments('id'); //это значит поле `id` INT AUTO_INCREMENT PPIMARY KEY
            $table->string('title',150); //varchar длинной 150 символов //Это заголовок для слайда
            $table->text('desctext');  //Text длинной неограничено  //Это для текста(текст-описание) для слайда
            $table->string('images',255);  //varchar длинной 255 символов //Это для хранения картинки(изображения) в виде ссылки(ок) для слайда
            $table->timestamps(); //для записи времени создания или изменения соответствующей записи в БД
        });
    }

    /** Reverse the migrations.
     * @return void
    */
    public function down()
    {
        Schema::dropIfExists('sliders');
    }
}
