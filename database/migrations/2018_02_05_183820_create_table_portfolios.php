<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePortfolios extends Migration
{
    /** Run the migrations.
     * @return void
    */
    public function up()
    {
        Schema::create('portfolios', function (Blueprint $table) { //Можно сразу к создаваемым ячейкам применять какие-то default-значения: $table->text('text')->default('some text..');
            //$table->engine = 'InnoDB'; //можно явно указать какой движок будет использоваться для табл.если не указывать, то использунтся движок,выбранный для БД вцелом
            $table->increments('id'); //это значит поле `id` INT AUTO_INCREMENT PPIMARY KEY
            $table->string('alias',100)->unique(); //varchar длинной 100 символов, уникальное поле //псевдоним для портфолио(slug) - его alias(название)
            $table->string('title',150); //varchar длинной 150 символов //Это заголовок для портфолио
            $table->text('text');  //Text длинной неограничено  //Это текст (описание) конкретного портфолио
            $table->string('customer',150);  //Text длинной 150 символов  //Это для хранения имени заказчика,которому делалась эта работа,находящаяся в портфолио
            $table->string('images',255);  //varchar длинной 255 символов //Это для хранения картинки(изображения/баннера) в виде ссылки(ок) для конкретного портфолио
            $table->timestamps(); //для записи времени создания или изменения соответствующей записи в БД
        });
    }

    /** Reverse the migrations.
     * @return void
    */
    public function down()
    {
        Schema::dropIfExists('portfolios');
    }
}
