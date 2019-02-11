<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorHandlerController extends Controller
{
    /** Method handler http-request with GET
     *  @return \Illuminate\Http\Response
    */
    public function errorCode404() {
        $show_controller_info = __METHOD__; 
        if( view()->exists('frontendsite.'.env('THEME').'.404') ){ 
            return view('frontendsite.'.env('THEME').'.404', [
                'show_controller_info' => $show_controller_info,
            ])->render();
        }
    }

    /** Method handler http-request with GET
     *  @return \Illuminate\Http\Response
    */
    public function errorCode405() {
        $show_controller_info = __METHOD__;

        if( view()->exists('frontendsite.'.env('THEME').'.404') ){  
            return view('frontendsite.'.env('THEME').'.404', [
                'show_controller_info' => $show_controller_info,
            ])->render();
        }
    }
}
