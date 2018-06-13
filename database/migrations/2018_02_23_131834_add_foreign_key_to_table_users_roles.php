<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyToTableUsersRoles extends Migration
{
    /** Run the migrations.
     * @return void
    */
    public function up()
    {   /* связующая таблица, по внешнему_ключу, между таблицами `users` и `roles` */
        if( Schema::hasTable('users_roles') ) {  //если такая таблица существует,то
            Schema::table('users_roles', function (Blueprint $table) {

                $table->integer('user_id')->unsigned()->default(1); //поле `user_id` будет "внешним_ключом" и будет связано с полем `id` таблицы `users`
                $table->foreign('user_id')->references('id')->on('users');

                $table->integer('role_id')->unsigned()->default(1); //поле `role_id` будет "внешним_ключом" и будет связано с полем `id` таблицы `roles`
                $table->foreign('role_id')->references('id')->on('roles');
            });
        }
    }

    /** Reverse the migrations.
     * @return void
    */
    public function down()
    {
        Schema::dropIfExists('users_roles');
    }
}
