<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyToTablePermissionsRoles extends Migration
{
    /** Run the migrations.
     * @return void
    */
    public function up()
    {   /* связующая таблица, по внешнему_ключу, между таблицами `permissions` и `roles` */
        if( Schema::hasTable('permissions_roles') ) {  //если такая таблица существует,то
            Schema::table('permissions_roles', function (Blueprint $table) {

                $table->integer('permission_id')->unsigned()->default(1); //поле `permission_id` будет "внешним_ключом" и будет связано с полем `id` таблицы `permissions`
                $table->foreign('permission_id')->references('id')->on('permissions');

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
        Schema::dropIfExists('permissions_roles');
    }
}
