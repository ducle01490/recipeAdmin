<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;

use App\Recipe;
use Response;

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
        $recipes = Recipe::orderBy('updated_at', 'DESC')->paginate(15);

        return view('recipes.list', compact('menu', 'recipes'));
    }

    public function updateStatus(Request $request, $recipeId, $status)
    {
        $recipe = Recipe::find($recipeId);
        if ($recipe) {
            $recipe->status = $status;
            $recipe->save();
        }

        return Redirect::back();
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
            $recipe = new Recipe();
            $recipe->title = Input::get('title');
            $recipe->thumb = Input::get('thumb');
            $recipe->ingredient = Input::get('ingredient');
            $recipe->preparation = Input::get('preparation');
            $recipe->video = Input::get('video');
            $recipe->price = Input::get('price');
            $recipe->serving = Input::get('serving');
            $recipe->status = Input::get('status');

            $recipe->save();
            if ($recipe->id) {
                return Redirect::back()->with('flash_notice', 'Tạo bài viết thành công!');
            } else {
                //save fail
                return Redirect::back()->with('flash_error', 'Tạo bài viết lỗi!');
            }
        }

        return view('recipes.add', compact('menu'));
    }

    public function edit(Request $request, $recipeId)
    {
        $menu = 'recipe';
        $recipe = Recipe::find($recipeId);

        if ($request->isMethod('post'))
        {
            $recipe->title = Input::get('title');
            $recipe->thumb = Input::get('thumb');
            $recipe->ingredient = Input::get('ingredient');
            $recipe->preparation = Input::get('preparation');
            $recipe->video = Input::get('video');
            $recipe->price = Input::get('price');
            $recipe->serving = Input::get('serving');
            $recipe->status = Input::get('status');

            $recipe->save();

            return Redirect::back()->with('flash_notice', 'Cập nhật thành công')->with(compact('recipe'));
        }

        return view('recipes.edit', compact('menu', 'recipe'));
    }

    public function delete(Request $request, $recipeId)
    {
        if ($request->isMethod('post'))
        {
            $recipe = Recipe::find($recipeId);
            if ($recipe) {
                $recipe->delete();
            }

            if ($request->ajax()) {
                return Response::json(array('status'=>'success', 'messages' => 'Xoá thành công', 'recipeId' => $recipeId));
            }

            return Redirect::back()->with('flash_notice', 'Xoá thành công');
        }
    }
}
