<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Supply;
use Yabacon;
// use App\customClasses\customCurl AS custCurl;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $supplies = Supply::with('supplier')->paginate(15);
        return view('home', ['supplies' => $supplies]);
    }

}
