<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTableUsers extends Migration
{
    /** Run the migrations.
     * @return void
    */
    public function up() {
        if( Schema::hasTable('users') ){

            Schema::table('users', function (Blueprint $table) {
                //добавляем в уже сущ.табл.`users` новую ячейку таблицы c именем 'alias'
                $table->string('provider',110)->nullable()->after('id'); //Varchar длинной 110 символов; Значение в этой ячейке может быть NULL
                //добавляем в уже сущ.табл.`users` новую ячейку таблицы c именем 'provider_id'
                $table->string('provider_id',250)->nullable()->after('id'); //Varchar длинной 250 символов; Значение в этой ячейке может быть NULL
            });
        }
    }

    /** Reverse the migrations.
     * @return void
    */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //и обязательно прописываем тут отмену того что в методе `up()` на случай отмены данной миграции - отката
            $table->dropColumn('provider');
            $table->dropColumn('provider_id');
            /* OR: $table->dropColumn(['provider', 'provider_id']); */
        });
    }
}
