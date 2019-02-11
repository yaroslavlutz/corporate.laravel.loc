<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class HomeController extends Controller
{
    protected $request;

    /** Create a new controller instance.
     * @param Request $request
    */
    public function __construct( Request $request ) {
        $this->middleware('auth');
        $this->request = $request;
    }

    /** Show the application dashboard.
     * @return \Illuminate\Http\Response
    */
    public function index()
    {
        return view('home');
    }
}
