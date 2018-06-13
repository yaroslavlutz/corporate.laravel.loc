<?php
namespace App\Policies;

use App\User;
use App\Article;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
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

    /** Determine whether the user can view the article.
     * @param  \App\User  $user
     * @param  \App\Article  $article
     * @return mixed
    */
    public function view(User $user, Article $article) {
        return $user->userCanDo( $user->id, 'VIEW_ADMIN_PANEL',false );
    }
    /** Determine whether the user can create articles.
     * @param  \App\User  $user
     * @return mixed
    */
    public function create(User $user) {
        return $user->userCanDo( $user->id, array('VIEW_ADMIN_PANEL','ADD_MATERIAL'),true );
    }
    /** Determine whether the user can update the article.
     * @param  \App\User  $user
     * @param  \App\Article  $article
     * @return mixed
    */
    public function update(User $user, Article $article) {
        /* Если нужно,чтобы редактировать статью мог не Админ,как сейчас,а и просто юзер,у кот.есть на это право и кот.имеено добавил данную статью,то нужно прописать примерно такую логику тут или в Контроллере:
         if( $user->id == $article->users()->id ) { return $user->userCanDo( $user->id, array('VIEW_ADMIN_PANEL','UPDATE_MATERIAL'),true ); } //т.е. ID текущего Юзера должно совпадать с `user_id` текущей Модели Article,- тогда это будет Юзер,кот.и добавил данную статью
        */
        return $user->userCanDo( $user->id, array('VIEW_ADMIN_PANEL','UPDATE_MATERIAL'),true );
    }
    /** Determine whether the user can delete the article.
     * @param  \App\User  $user
     * @param  \App\Article  $article
     * @return mixed
    */
    public function delete(User $user, Article $article) {
        /* Если нужно,чтобы удалять статью мог не Админ,как сейчас,а а и просто юзер,у кот.есть на это право и кот.имеено добавил данную статью,то нужно прописать примерно такую логику тут или в Контроллере:
         if( $user->id ==$article->users()->id  ) { return $user->userCanDo( $user->id, array('VIEW_ADMIN_PANEL','DELETE_MATERIAL'),true ); } //т.е. ID текущего Юзера должно совпадать с `user_id` текущей Модели Article,- тогда это будет Юзер,кот.и добавил данную статью
        */
        return $user->userCanDo( $user->id, array('VIEW_ADMIN_PANEL','DELETE_MATERIAL'),true );
    }

}  //__/class ArticlePolicy
