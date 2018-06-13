<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //Or: use DB; - доступ к Кл-Фасаду `DB` для работы с БД напрямую(не через Модель),например,когда вот так: $result_pages = DB::table('pages')->get()->toArray();

class HomeController extends Controller
{
    protected $request; //для Объекта Класса `Request` с которым мы будем в данном Контроллере работать

    /** Create a new controller instance.
     * @param Request $request
    */
    public function __construct( Request $request ) {
        $this->middleware('auth');
        $this->request = $request;  //перекладываем Объект Класса `Request` что в $request в созданное нами protected свойство $request ($this->request).
    }

    /** Show the application dashboard.
     * @return \Illuminate\Http\Response
    */
    public function index()
    {
        return view('home');
        //return view('admin_home');
    }
}
