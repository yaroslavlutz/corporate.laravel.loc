<?php
namespace App\Policies;

use App\User;
use App\Menu;
use Illuminate\Auth\Access\HandlesAuthorization;

class MenuPolicy
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

    /** Determine whether the user can view the menu.
     * @param  \App\User  $user
     * @param  \App\Menu  $menu
     * @return mixed
    */
    public function view(User $user, Menu $menu) {
        return $user->userCanDo( $user->id, 'VIEW_ADMIN_PANEL',false );
    }
    /** Determine whether the user can create menus.
     * @param  \App\User  $user
     * @return mixed
    */
    public function create(User $user) {
        return $user->userCanDo( $user->id, array('VIEW_ADMIN_PANEL','ADD_MATERIAL'),true );
    }
    /** Determine whether the user can update the menu.
     * @param  \App\User  $user
     * @param  \App\Menu  $menu
     * @return mixed
    */
    public function update(User $user, Menu $menu) {
        return $user->userCanDo( $user->id, array('VIEW_ADMIN_PANEL','UPDATE_MATERIAL'),true );
    }
    /** Determine whether the user can delete the menu.
     * @param  \App\User  $user
     * @param  \App\Menu  $menu
     * @return mixed
    */
    public function delete(User $user, Menu $menu) {
        return $user->userCanDo( $user->id, array('VIEW_ADMIN_PANEL','DELETE_MATERIAL'),true );
    }
}
