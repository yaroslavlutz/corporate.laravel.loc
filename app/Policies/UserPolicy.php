<?php
namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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

    /** Determine whether the user can view the model.
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
    */
    public function view(User $user, User $model) {
        return $user->userCanDo( $user->id, 'VIEW_ADMIN_PANEL',false );
    }
    /** Determine whether the user can create models.
     * @param  \App\User  $user
     * @return mixed
    */
    public function create(User $user) {
        return $user->userCanDo( $user->id, array('VIEW_ADMIN_PANEL','ADD_USERS'),true );
    }
    /** Determine whether the user can update the model.
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
    */
    public function update(User $user, User $model) {
        return $user->userCanDo( $user->id, array('VIEW_ADMIN_PANEL','UPDATE_USERS'),true );
    }
    /** Determine whether the user can delete the model.
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
    */
    public function delete(User $user, User $model) {
        return $user->userCanDo( $user->id, array('VIEW_ADMIN_PANEL','DELETE_USERS'),true );
    }
}
