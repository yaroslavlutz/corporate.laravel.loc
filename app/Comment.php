<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    public $timestamps = TRUE; //FALSE
    protected $fillable = ['id', 'parent_comment_id', 'text', 'name', 'email', 'site', 'user_id', 'article_id', 'created_at', 'updated_at'];
    protected static $_select = ['id', 'parent_comment_id', 'text', 'name', 'email', 'site', 'user_id', 'article_id', 'created_at', 'updated_at'];
    protected $guarded = [
    ];


    /** Get all Comments from DB for frontend-part
     * @param bool/array $select - array with the listed fields that you need to take
     * @param bool/int $pagination - Pagination(how many entries to display on one page)
     * @param bool/array $relationload - Load into the data sample the data of the relationship Models or not. If FALSE - not
     * @param array $where - array with query parameters for the SQL-query to DB
     * @return object (collection Models)
    */
    public static function get_entries( $select=FALSE, $pagination=FALSE, $relationload=FALSE, $where=array() ) {
        if( !$select ) { $select = self::$_select; }
        if( !$pagination ) {
            if( count($where) > 0 ) { $result_entries = self::select( $select )->where( $where[0],$where[1],$where[2] )->get(); }
            else { $result_entries = self::select( $select )->get();  } 
            if( $result_entries && $relationload ) { $result_entries->load( $relationload ); }
        }
        else { 
            if( count($where) > 0 ) { $result_entries = self::select( $select )->where( $where[0],$where[1],$where[2] )->paginate($pagination); }
            else { $result_entries = self::select( $select )->paginate($pagination); }
            if( $result_entries && $relationload ) { $result_entries->load( $relationload ); }
        }
        return $result_entries;
    }

    /** RELATIONSHIPS: */
    public function articles() {
        return $this->belongsTo('App\Article', 'article_id','id');
    }

    public function users() { 
        return $this->belongsTo('App\User', 'user_id','id');
    }

}
