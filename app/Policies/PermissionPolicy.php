<?php
namespace App\Policies;

use App\User;
use App\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy
{
    use HandlesAuthorization;
    /** PERMISSIONS (DB table `permissions`):
     * VIEW_ADMIN_PANEL - просматривать Гл.страницу Админ-панели
     * ADD_MATERIAL - добавлять новый материал
     * UPDATE_MATERIAL - обновлять/редактировать материал
     * DELETE_MATERIAL - удалять материал
     * ADD_USERS - добавлять нового Юзера
     * UPDATE_USERS - обновлять/редактировать Юзера
     * DELETE_USERS - удалять Юзера
     * (!)по-хорошему следовало бы в этот список добавить такую привилегию,как CHANGE_PERMISSION_FOR_ROLE_USER - изменять привилегии для ролей Юзеров,что мы и реализуем в `PermissionResourceController.php`
     */
    //__________________________________________________________________________________________________________________

    /** Create a new policy instance.
     * @return void
    */ public function __construct() {}

    /** Determine whether the user can view the article.
     * @param  \App\User  $user
     * @param  \App\Permission $permission
     * @return mixed
    */
    public function view(User $user, Permission $permission) {
        return $user->userCanDo( $user->id, 'VIEW_ADMIN_PANEL',false );
    }
    /** Determine whether the user can update the article.
     * @param  \App\User  $user
     * @param  \App\Permission $permission
     * @return mixed
    */
    public function update(User $user, Permission $permission) {
        return $user->userCanDo( $user->id, array('VIEW_ADMIN_PANEL','UPDATE_USERS'),true );
    }


} //__/class PermissionPolicy
