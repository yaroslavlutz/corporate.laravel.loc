<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMenus extends Migration
{
    /** Run the migrations.
     * @return void
    */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {  //Можно сразу к создаваемым ячейкам применять какие-то default-значения: $table->text('text')->default('some text..');
            //$table->engine = 'InnoDB'; //можно явно указать какой движок будет использоваться для табл.если не указывать, то использунтся движок,выбранный для БД вцелом
            $table->increments('id'); //это значит поле `id` INT AUTO_INCREMENT PPIMARY KEY
            $table->integer('parent_menu_id'); //это ID родительского пункта меню,если пункт меню вложенный,т.к.предпологается древовидность меню(двууровневое Меню)
            $table->string('title',50); //varchar длинной 50 символов //заголовок пункта меню
            $table->string('url_path',255); //varchar длинной 255 символов //Это URL для пункта меню
            $table->timestamps(); //для записи времени создания или изменения соответствующей записи в БД
        });
    }

    /** Reverse the migrations.
     * @return void
    */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
