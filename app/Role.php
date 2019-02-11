<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    public $timestamps = TRUE; //FALSE
    protected $fillable = ['id', 'name', 'created_at', 'updated_at'];
    protected static $_select = ['id', 'name', 'created_at'];
    protected $guarded = [
    ];

    /** Get all Role from DB for backend-part
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

    public function hasPermissions( $currentRoleID, $permission ) {
        $permissions_res = $this->find($currentRoleID)->permissions()->get();
        foreach( $permissions_res as $i_permission ) {
            if( $permission === $i_permission->name ) {
                return TRUE;
            }
        }
        return FALSE;
    } 

    function savePermissions( $permission ) {
        if( !empty($permission) ) {
            $this->permissions()->sync($permission);
        }
        else { 
            $this->permissions()->detach();
        }
        return TRUE;
    }

    /** RELATIONSHIPS: */
    public function users() {
        return $this->belongsToMany('App\User', 'users_roles');
    }

    public function permissions() { 
        return $this->belongsToMany('App\Permission','permissions_roles');
    }
}
