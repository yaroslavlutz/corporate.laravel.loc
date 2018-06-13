<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableComments extends Migration
{
    /** Run the migrations.
     * @return void
    */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) { //Можно сразу к создаваемым ячейкам применять какие-то default-значения: $table->text('text')->default('some text..');
            //$table->engine = 'InnoDB'; //можно явно указать какой движок будет использоваться для табл.если не указывать, то использунтся движок,выбранный для БД вцелом
            $table->increments('id'); //это значит поле `id` INT AUTO_INCREMENT PPIMARY KEY
            $table->integer('parent_comment_id'); //это ID родительского комментария,если комментарий на комментарий,т.к.предпологается древовидность комментариев
            $table->text('text');  //Text длинной неограничено  //Это самого комментария
            $table->string('name',150); //varchar длинной 150 символов //Это имя незарегистрированного,но оставившего комментарий пользователя
            $table->string('email',50); //varchar длинной 50 символов //Это E-mail незарегистрированного,но оставившего комментарий пользователя
            $table->string('site',150); //varchar длинной 150 символов //Это web-сайт(если он есть) незарегистрированного,но оставившего комментарий пользователя
            $table->timestamps(); //для записи времени создания или изменения соответствующей записи в БД
        });
    }

    /** Reverse the migrations.
     * @return void
    */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
