<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;

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
        $menu = 'recipe';

        return view('recipes.list', compact('menu'));
    }

    /**
     * Create new recipe
     *
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        $menu = 'recipe';

        if ($request->isMethod('post'))
        {
            dd(Input::all());
        }

        return view('recipes.add', compact('menu'));
    }
}
