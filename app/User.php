<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /** The attributes that are mass assignable.
     * @var array
    */
    protected $fillable = [ 'name', 'email', 'password', 'provider', 'provider_id' ];

    /** The attributes that should be hidden for arrays.
     * @var array
    */
    protected $hidden = [ 'password', 'remember_token' ];
    //__________________________________________________________________________________________________________________


    /** RELATIONSHIPS: */
    /* Указываем,что мы хотим использовать связь табл.`users` c табл.`articles` (последняя табл.у нас ассоциирована с Моделью `App/Article.php`).
       Поле `user_id` из табл.`articles` как внешний ключ(foreign-key) и связан с полем `id` табл.`users`.
       Данная связь `1: ко многим` - 1 Юзер может иметь много записей(articles) в табл.`articles`
    */
    public function articles() {  //аналогично-противоп.метод прописан в Модели 'app/Article.php'
        //1-й парам.- Модель,с кот.связана текущ.Модель; 2-й парам.- имя поля табл.БД которое есть foreign-key для 2-х таблиц; 3-й парам.- имя поля табл.БД с которым foreign-key связан
        return $this->hasMany('App\Article', 'user_id', 'id');
    }

    /* Указываем,что мы хотим использовать связь табл.`users` c табл.`comments` (последняя табл.у нас ассоциирована с Моделью `App/Comment.php`).
       Поле `user_id` из табл.`comments` как внешний ключ(foreign-key) и связан с полем `id` табл.`users`.
       Данная связь `1: ко многим` - 1 Юзер может иметь много комментариев(comments) в табл.`comments`
    */
    public function comments() {  //аналогично-противоп.метод прописан в Модели 'app/Comment.php'
        //1-й парам.- Модель,с кот.связана текущ.Модель; 2-й парам.- имя поля табл.БД которое есть foreign-key для 2-х таблиц; 3-й парам.- имя поля табл.БД с которым foreign-key связан
        return $this->hasMany('App\Comment', 'user_id','id');
    }

    /* Указываем,что мы хотим использовать связь табл.`users` c табл.`roles` (последняя табл.у нас ассоциирована с соответств.Моделью `app/Role.php`).
       Для этой связи имеется связующ.табл.`users_roles` в кот.имеется 2 foreign-key: `user_id` и `role_id`.
       Данная связь `много: к многим` -  1 Юзер может иметь несколько ролей, но при этом роли могут относиться к многим Юзерам одновременно.
    */
    public function roles() {  //аналогично-противоп.метод прописан в Модели 'app/Roles.php'
        /* 1-й парам.- Модель,с кот.связана текущ.Модель;
           2-й парам.- имя связующей(посредника) таблицы меж табл.`users` и `roles`;
           3-й ппарам. и 4-й ппарам.- 'внешние_ключи' этой самой связующей(посредника) таблицы
        */
        return $this->belongsToMany('App\Role','users_roles');
        //return $this->belongsToMany('App\Role','users_roles', 'user_id', 'role_id');
    }


    /** canDo - Проверяем имеет ли текущий Юзер права на определенные дествия на сайте.
     * @param $currentUserID - ID текущего аутентифицированного Юзера
     * @param string/array $permission - определенное право для Юзера,которое проверяется или набор прав,которые проверяются в массиве
     * @param bool $require - флаг. Проверять одно определенное право для Юзера($require=FALSE) или весь массив прав,который передается для проверки($require=TRUE).
                                    В последнем случае(когда $require=TRUE) Ф-я `canDo()` вернет true, только если ВЕСЬ массив прав для Юзера подтверждается,иначе - false.
                                    Если передано $require=FALSE, а проверямые Права юзера указаны как массив, а не как одно Право,то `canDo()` вернет true, т.к. $require=FALSE и значит достаточно чтобы хоть одно право подтвердилось
     * @return bool
    */  /*(!) Модель `User` связана с `Role` а уже `Role` с `Permission` */
    public function userCanDo( $currentUserID ,$permission, $require=FALSE ) {
        $roles_of_user = $this->find($currentUserID)->roles()->get();  //вернет все доступные роли(в виде коллекции) для данного текущ.Юзера //dd($roles_of_user[0]->name);

        if( is_array($permission) ) { //если передан целый массив прав для Юзера на проверку
            foreach( $permission as $item_perm ) { //level-1
                /* $item_perm - имя конкретного права */
                $item_perm = $this->userCanDo($currentUserID, $item_perm); //рекурсия
                //When $require=FALSE
                if( $item_perm && !$require ) { //true && true
                    return TRUE;
                }
                //When $require=TRUE - т/е проверять все переданные права на соответствие и,если хоть одно false - то возвращаем FALSE
                else if( !$item_perm && $require ) { //false && true
                    return FALSE; //как только $item_perm будет == false, то сразу возвращаем FALSE,т.к.тут нас интересует случай,когда все Права будут true
                }
            }
            return $require;
        }
        else { //если передано одно конкретное право для Юзера на проверку
            $roles_of_user = $this->find($currentUserID)->roles()->get();  //вернет все доступные роли(в виде коллекции) для данного текущ.Юзера //dd($roles_of_user[0]->name);
            //$permissions_of_user = $roles_of_user[0]->permissions()->get(); //вернет все доступные Права(permissions)(в виде коллекции) для данной Роли,которая принадлежит Юзеру с ID = $currentUserID
            //dd($permissions_of_user[0]->name); - чтобы просмотреть определенное имя Права(permission)

            foreach( $roles_of_user as $item_role ) { //level-1

                //$item_role->permissions()->get() //вернет все доступные Права(permissions)(в виде коллекции) для данной(текущей в цикле) Роли (а все роли для Юзера у нас уже выбраны в $roles_of_user )
                foreach( $item_role->permissions()->get() as $item_perm ) { //level-2
                    if( $permission === $item_perm->name ) { //в $item_perm->name попадает именно имя определенного Права для Юзера ('VIEW_ADMIN_PANEL', 'ADD_MATERIAL', 'UPDATE_MATERIAL'...)
                        return TRUE; //если проверяемые права совпали,-вернем TRUE - т.е. USER имеет права на это действие указанное в $permission
                    }
                } //_/level-2

            } //_/level-1
            return FALSE;
        }
    } //__/public function canDo()



    /* TODO: Доработать метод!!
        Доработать метод!! Он похож на `userCanDo()` , только даже проще,т/к должен проверять только роль/роли для указанного Юзера. Сделал скрин его метода
    */
    public function userHasRole( $currentUserID ,$permission, $require=FALSE ) {
        $roles_of_user = $this->find($currentUserID)->roles()->get();  //вернет все доступные роли(в виде коллекции) для данного текущ.Юзера //dd($roles_of_user[0]->name);

        if( is_array($permission) ) { //если передан целый массив прав для Юзера на проверку
            foreach( $permission as $item_perm ) { //level-1
                /* $item_perm - имя конкретного права */
                $item_perm = $this->userHasRole($currentUserID, $item_perm); //рекурсия
                //When $require=FALSE
                if( $item_perm && !$require ) { //true && true
                    return TRUE;
                }
                //When $require=TRUE - т/е проверять все переданные права на соответствие и,если хоть одно false - то возвращаем FALSE
                else if( !$item_perm && $require ) { //false && true
                    return FALSE; //как только $item_perm будет == false, то сразу возвращаем FALSE,т.к.тут нас интересует случай,когда все Права будут true
                }
            }
            return $require;
        }
        else { //если передано одно конкретное право для Юзера на проверку
            $roles_of_user = $this->find($currentUserID)->roles()->get();  //вернет все доступные роли(в виде коллекции) для данного текущ.Юзера //dd($roles_of_user[0]->name);
            //$permissions_of_user = $roles_of_user[0]->permissions()->get(); //вернет все доступные Права(permissions)(в виде коллекции) для данной Роли,которая принадлежит Юзеру с ID = $currentUserID
            //dd($permissions_of_user[0]->name); - чтобы просмотреть определенное имя Права(permission)

            foreach( $roles_of_user as $item_role ) { //level-1

                //$item_role->permissions()->get() //вернет все доступные Права(permissions)(в виде коллекции) для данной(текущей в цикле) Роли (а все роли для Юзера у нас уже выбраны в $roles_of_user )
                foreach( $item_role->permissions()->get() as $item_perm ) { //level-2
                    if( $permission === $item_perm->name ) { //в $item_perm->name попадает именно имя определенного Права для Юзера ('VIEW_ADMIN_PANEL', 'ADD_MATERIAL', 'UPDATE_MATERIAL'...)
                        return TRUE; //если проверяемые права совпали,-вернем TRUE - т.е. USER имеет права на это действие указанное в $permission
                    }
                } //_/level-2

            } //_/level-1
            return FALSE;
        }
    } //__/public function userHasRole()


} //__/class User
