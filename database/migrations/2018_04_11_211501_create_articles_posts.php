<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesPosts extends Migration
{
    /**Run the migrations.
     * @return void
    */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('views_left');

            /*  http://laravel.su/docs/5.4/migrations  and  https://laravel.com/docs/5.5/migrations
            ENUM(перечисление) -это столбец,кот.может принимать зн-е из списка допустимых зн-й,явно перечисленных в спецификации столбца в момент создания таблицы.Этим зн-ем также может быть пустая строка или NULL.
            Если делается всавка некорректного зн-я в столбец ENUM (т.е. вставка строки,не перечисленной в списке допустимых),то вставляется пустая строка,что является указанием на ошибочное значение.
            Эта строка отличается от "обычной" пустой строки по тому признаку,что она имеет цифровое значение, равное 0. Если ENUM определяется как NULL,то тогда NULL тоже является допустимым зн-ем столбца и зн-е по умолчанию - NULL.
            Если ENUM определяется как NOT NULL,то зн-ем по умолчанию является первый элемент из списка допустимых значений. */
            $table->enum('type', ['status','video','photo'])->default('status');

            $table->timestamps();
        });
    }

    /**Reverse the migrations.
     * @return void
    */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
