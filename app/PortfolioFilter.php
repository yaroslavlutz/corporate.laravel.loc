<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class PortfolioFilter extends Model
{
    protected $table = 'portfolio_filters';
    public $timestamps = TRUE; //FALSE
    protected $fillable = ['id', 'alias', 'title', 'created_at', 'updated_at'];
    protected static $_select = ['id', 'alias', 'title'];
    protected $guarded = [
    ];

    /** Get all PortfolioFilters from DB for frontend-part
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

    /** Get id category of article
     * @param int $cat
     * @return object
    */
    public static function get_cat_id( $filter ) {
        $result_entries = self::select('id')->where('alias','=',$filter)->get();
        return $result_entries;
    }

    /** RELATIONSHIPS: */
    public function portfolios() { 
        return $this->hasMany('App\Portfolio', 'portfolio_filter_alias', 'alias');
    }
}
