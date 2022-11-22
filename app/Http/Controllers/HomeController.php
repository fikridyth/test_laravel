<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    private static $title = 'Dashboard';

    public static function breadcrumb()
    {
        return [
            self::$title, route('index')
        ];
    }

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
        $breadcrumbs = [
            self::breadcrumb()
        ];

        $title = self::$title;

        return view('dashboard', compact('title', 'breadcrumbs'));
    }
}
