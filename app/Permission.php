<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';
    public $timestamps = TRUE; //FALSE
    protected $fillable = ['id', 'name', 'created_at', 'updated_at'];
    protected static $_select = ['id', 'name', 'created_at'];
    protected $guarded = [

    ];

    /** Get all Permissions from DB for backend-part
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
    public function roles() {
        return $this->belongsToMany('App\Role','permissions_roles');
    }
}
