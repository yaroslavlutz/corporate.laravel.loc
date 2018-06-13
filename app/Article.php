<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /* Указываем конкретно имя табл.БД с которой мы будем работать и которая будет нам доступна через свойства этого Класса.
          Когда имя Модели в единственном числе совпадает с именем табл.БД во множественном числе,то можно будет свойство `protected $table` не писать.
          Но можно указать и дуругую(какую нужно таблицу),вот тогда в `protected $table` нужно обязательно указать имя табл.БД с которой мы будем раблтать в этой Модели
    */
    protected $table = 'articles';

    /* По умолчанию Laravel считает, что у нас идентификатор в таблице,кот.определена для этой Модели это именно поле `id` где задано `Primary Key`. Когда это действительно так,то это свойство можно не писать,
        т.к. такое правило действует по-умолчанию. Но если это не так, то тут тогда прописываем имя поля,которое у нас есть таким идентификатором с `Primary Key`
    */ /* protected $primaryKey = 'id'; */

    /* Также по умолчанию Laravel считает, что у нас идентификатор в таблице,кот.определена для этой Модели и который,если отличается от ожидаемого идентификатора с именем `id` то прописывается
     в `protected $primaryKey`, - имеет и свойство `autoincrement`,которое как известно,при вставке новой записи в соотв.табл.БД добавляет следующ.номер идентификатору `id`. Если у нас, наш
     идентификатор (а у нас он именно `id`) не имеет такого свойства как `autoincrement` то тут ставится FALSE. Иначе ничего не нужно прописывать вообще.
    */ /* public $incrementing = TRUE; //FALSE* /

    /* Также по умолчанию Laravel считает, что в таблице есть поля для храниния timestamp создания записи и timestamp обновления записи(т.е. поля `created_at` и `updated_at`) и,как правила такие поля есть
     у той или иной таблицы, т.к.это нужные поля и могут быть очень полезными. Но если нам не нужно в них хранить такие данные, то тут мы указываем FALSE.
    */
    public $timestamps = TRUE; //FALSE

    /** The attributes that are mass assignable.
     *  @var array
     */ /* Прописываем имена тех полей табл.БД, в которые мы разрешаем делать запись(вставки данных INSERT) используя метод Модели для работы с БД `create()`.
           Это нужно только для метода `create()`. Поля,которые тут не указаны, и при использ.`create()`, будут игнорироваться при записи данных в них.
        */
    protected $fillable = ['id', 'alias', 'title', 'desctext', 'fulltext', 'images', 'articles_category_id', 'user_id', 'created_at', 'updated_at'];
    protected static $_select = ['id', 'alias', 'title', 'desctext', 'fulltext', 'images', 'articles_category_id', 'user_id', 'created_at'];

    /* Противоположное по смыслу св-ву $fillable св-во $guarded. Имена полей,помещенных в него будут наоборот закрыты для записи. Если прописать protected $guarded = [*] то все поля будут закрыты для записи.*/
    protected $guarded = [
        //'id', 'alias', 'title', 'desctext', 'fulltext', 'images', 'articles_category_id', 'user_id', 'created_at', 'updated_at'
    ];

    /* В этом закрытом св-ве $casts мы можем указать в каком виде сохранять данные в соответствующих полях табл.БД с котрой эта Модель работает. В виду этого очень интересным есть момент при котором мы можем в
        нужное поле табл. хранить данные в виде Массива. Это и так вожно и обычно это делают руками - переводят данные в массив и серриализуют его в строку json и в таком виде они лежат в БД. Здесь это за нас сделает
        Laravel, а нам нужно всего лишь указать ему в данном спец.свойстве в каком поле мы хотим хранить данные в виде массива(а по-существу в виде json-строки). Так,например, в табл.`articles` с котрой работает эта Модель,
        у нас есть поле `text` и мы хотим , чтобы данные в нем могли храниться в виде массива(а по-существу в виде json-строки).
        Для сохранения данных теперь в виде массива с его послед. серриализацией и перевода в json-строку в Контроллере, в кот.мы работаем с этой Моделью `app/Http/Controllers/Admin/ArticleController.php` нужно,
        например,прописать вот так (или др.способом для INSERT или UPDATE  данных в таблицу):
                $article_id_14 = Article::find(14); //выбираем из табл.`articles` запись с ID = 14
                $arr_to_save = ['one'=>'1111111111', 'two'=>'2222222222', 'three'=>'3333333333']; //массив с нужными данными для поля `text` табл.`articles`
                $article_id_14->text = $arr_to_save;
                $article_id_14->save();  dump( Article::find(14)->text );
        И теперь, чтобы вывести такие данные: echo Article::find(14)->text['one']; echo Article::find(14)->text['two']; echo Article::find(14)->text['three'];
        Опять же, теперь можно и в виде строки записывать как и было и в виде массива(а по-существу в виде json-строки), что очень удобно и функционально (!!!).

    protected $casts = [
        'images'=>'array',  //данные,которые будут сохраняться в поле `text` табл.`pages` будут массивом,который Laravel будет сам серрилиазовать и переводить в json-строку
    ];
    */
    //_______________________________________________________________________________________________________________________________________

    /** Get all Articles from DB for backend-part
     * @param bool/array $select - array with the listed fields that you need to take
     * @param bool/int $pagination - Pagination(how many entries to display on one page)
     * @param bool/array $relationload - Load into the data sample the data of the relationship Models or not. If FALSE - not
     * @param array $where - array with query parameters for the SQL-query to DB
     * @return object (collection Models)
    */
    public static function get_entries( $select=FALSE, $pagination=FALSE, $relationload=FALSE, $where=array() ) {
        if( !$select ) { $select = self::$_select; }
        if( !$pagination ) {  //Если пагинация не нужна
            if( count($where) > 0 ) { $result_entries = self::select( $select )->where( $where[0],$where[1],$where[2] )->get(); }
            else { $result_entries = self::select( $select )->get();  }  //Article::get( $select );
            /* Если к выборке данных данной Модели нужно подгрузить данные связанных Моделей. Указываются имена методов связи меж ними */
            if( $result_entries && $relationload ) { $result_entries->load( $relationload ); }
        }
        else {  //Если пагинация нужна
            if( count($where) > 0 ) { $result_entries = self::select( $select )->where( $where[0],$where[1],$where[2] )->paginate($pagination); }
            else { $result_entries = self::select( $select )->paginate($pagination); }
            /* Если к выборке данных данной Модели нужно подгрузить данные связанных Моделей. Указываются имена методов связи меж ними */
            if( $result_entries && $relationload ) { $result_entries->load( $relationload ); }
        }
        return $result_entries;
        //Article::get( array('id', 'alias', 'title', 'desctext', 'fulltext', 'images', 'articles_category_id', 'user_id') )->toArray(); //Article::all()->toArray();
        //Article::select('id', 'alias', 'title', 'desctext', 'fulltext', 'images', 'articles_category_id', 'user_id')->get()->toArray();
    }  //__/public static function get_entries()


    /** Get single Article from DB for frontend-part
     * @param array $where - array with query parameters for the SQL-query to DB
     * @return object (collection Models)
    */
    public static function get_single_entry( $where=array() ) {
        return $result_entries = self::select( self::$_select )->where( $where[0],$where[1],$where[2] )->get();
    }


    /** RELATIONSHIPS: */
    /* Указываем,что мы хотим использовать связь табл.`articles` c табл.`users` (последняя табл.у нас ассоциирована с Моделью `App/User.php`).
       Поле `user_id` из табл.`articles` как внешний ключ(foreign-key) и связан с полем `id` табл.`users`.
       Данная связь `1: ко многим` - 1 Юзер может иметь много записей(articles) в табл.`articles`
    */
    public function users() {  //аналогично-противоп.метод прописан в Модели 'app/User.php'
        //1-й парам.- Модель,с кот.связана текущ.Модель; 2-й парам.- имя поля табл.БД которое есть foreign-key для 2-х таблиц; 3-й парам.- имя поля табл.БД с которым foreign-key связан
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    /* Указываем,что мы хотим использовать связь табл.`articles` c табл.`articles_categories` (последняя табл.у нас ассоциирована с Моделью `ArticleCategory.php`).
       Поле `articles_category_id` из табл.`articles` как внешний ключ(foreign-key) и связан с полем `id` табл.`articles_categories`.
       Данная связь `1: ко многим` - 1 категория может иметь много записей(articles) в табл.`articles`
    */
    public function articlesCategories() {  //аналогично-противоп.метод прописан в Модели 'app/ArticleCategory.php'
        //1-й парам.- Модель,с кот.связана текущ.Модель; 2-й парам.- имя поля табл.БД которое есть foreign-key для 2-х таблиц; 3-й парам.- имя поля табл.БД с которым foreign-key связан
        return $this->belongsTo('App\ArticleCategory', 'articles_category_id', 'id');
    }

    /* Указываем,что мы хотим использовать связь табл.`articles` c табл.`comments` (последняя табл.у нас ассоциирована с Моделью `App/Comment.php`).
       Поле `article_id` из табл.`comments` как внешний ключ(foreign-key) и связан с полем `id` табл.`articles`.
       Данная связь `1: ко многим` - 1 запись(articles) может иметь много комментариев(comments) в табл.`comments`
    */
    public function comments() {  //аналогично-противоп.метод прописан в Модели 'app/Comment.php'
        //1-й парам.- Модель,с кот.связана текущ.Модель; 2-й парам.- имя поля табл.БД которое есть foreign-key для 2-х таблиц; 3-й парам.- имя поля табл.БД с которым foreign-key связан
        return $this->hasMany('App\Comment', 'article_id','id');
    }

}  //__/Article
