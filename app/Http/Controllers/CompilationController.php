<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;

use App\Recipe;
use App\Compilation;
use Response;

class CompilationController extends Controller
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
     * Show the list recipes
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $menu = 'compilation';
        $compilations = Compilation::orderBy('updated_at', 'DESC')->paginate(15);

        return view('compilations.list', compact('menu', 'compilations'));
    }

    public function add(Request $request)
    {
    	$menu = 'compilation';

        if ($request->isMethod('post'))
        {
            $compilation = new Compilation();
            $compilation->title = Input::get('title');
            $compilation->thumb = Input::get('thumb');
            $compilation->video = Input::get('video');
            $compilation->status = Input::get('status');

            $compilation->save();
            if ($compilation->id) {
                return Redirect::back()->with('flash_notice', 'Tạo bài viết thành công!');
            } else {
                //save fail
                return Redirect::back()->with('flash_error', 'Tạo bài viết lỗi!');
            }
        }

        return view('compilations.add', compact('menu'));
    }


}