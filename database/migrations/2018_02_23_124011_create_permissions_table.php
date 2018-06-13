<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    /** Run the migrations.
     * @return void
    */
    public function up()
    { /* Для хранения имен прав для ролей для Юзеров
                Роли Права связаны с 1-й таблицей (через связующую таблицу):
                    с `roles` - право/права принадлежат Роли/Ролям - связь `многие к многим` (через связующ.таб.`permissions_roles`, в кот.нах. `foreign_key`)
      */
        Schema::create('permissions', function (Blueprint $table) { //Можно сразу к создаваемым ячейкам применять какие-то default-значения: $table->text('text')->default('some text..');
            //$table->engine = 'InnoDB'; //можно явно указать какой движок будет использоваться для табл.если не указывать, то использунтся движок,выбранный для БД вцелом
            $table->increments('id'); //это значит поле `id` INT AUTO_INCREMENT PPIMARY KEY
            $table->string('name', 150); //varchar длинной 150 символов //Это заголовок для статьи
            $table->timestamps(); //для записи времени создания или изменения соответствующей записи в БД
        });
    }

    /** Reverse the migrations.
     * @return void
    */
    public function down()
    {
        Schema::dropIfExists('permissions');
    }
}
