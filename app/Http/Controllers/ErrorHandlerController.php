<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorHandlerController extends Controller
{
    /** Method handler http-request with GET
     *  @return \Illuminate\Http\Response
    */
    public function errorCode404() {
        $show_controller_info = __METHOD__; //для наглядного отображение в View,которое рендерится,имени Контроллера и Метода,кот.непосредственно рендерит View
        //______________________________________________________________________________________________________________________________________________________

        /* => Рендерим View */
        if( view()->exists('frontendsite.'.env('THEME').'.404') ){  //проверяем, есть ли такая View по такому пути, если да, то тогда ее будем рендерить в метод view()
            return view('frontendsite.'.env('THEME').'.404', [
                'show_controller_info' => $show_controller_info,
            ])->render(); //->render() - можно не писать
        }
    }

    /** Method handler http-request with GET
     *  @return \Illuminate\Http\Response
    */
    public function errorCode405() {
        $show_controller_info = __METHOD__; //для наглядного отображение в View,которое рендерится,имени Контроллера и Метода,кот.непосредственно рендерит View
        //______________________________________________________________________________________________________________________________________________________

        /* => Рендерим View */
        if( view()->exists('frontendsite.'.env('THEME').'.404') ){  //проверяем, есть ли такая View по такому пути, если да, то тогда ее будем рендерить в метод view()
            return view('frontendsite.'.env('THEME').'.404', [
                'show_controller_info' => $show_controller_info,
            ])->render(); //->render() - можно не писать
        }
    }
} //__/class ErrorHandlerController
