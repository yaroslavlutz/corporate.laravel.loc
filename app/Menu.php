<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';
    public $timestamps = TRUE; //FALSE
    protected $fillable = ['id', 'parent_menu_id', 'title', 'url_path', 'created_at', 'updated_at'];
    protected $guarded = [
    ];

    /** Get all Menu from DB for frontend-part
     *  @return  array
    */
    public static function get_all_menu() {
        $result_menu = self::get( array('id', 'parent_menu_id', 'title', 'url_path') )->toArray();
        return $result_menu;
    }

}
