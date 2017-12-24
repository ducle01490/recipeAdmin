<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecipeController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the list recipes
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        return view('recipes.list');
    }

    /**
     * Create new recipe
     *
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        return view('recipes.add');
    }
}
