<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

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

    public function edit(Request $request, $compilationId)
    {
    	$menu = 'compilation';
    	$compilation = Compilation::findOrFail($compilationId);

        if ($request->isMethod('post'))
        {
            $compilation->title = Input::get('title');
            $compilation->thumb = Input::get('thumb');
            $compilation->video = Input::get('video');
            $compilation->status = Input::get('status');

            $compilation->save();

            return Redirect::back()->with('flash_notice', 'Cập nhật thành công')->with(compact('compilation'));
        }

        return view('compilations.edit', compact('menu', 'compilation'));
    }

    // action = 0: delete all recipe
    // action = 1: update all recipe
    public function delete(Request $request, $compilationId)
    {
        $action = (int)($request->query('action', '0'));

        if ($request->isMethod('post'))
        {
            $compilation = Compilation::findOrFail($compilationId);
            if ($compilation) {
                $compilation->delete();
            }

            if ($action == 0) {//delete
                DB::table('recipes')
                    ->where('compilationId', $compilationId)
                    ->delete();
            } else {//update
                DB::table('recipes')
                    ->where('compilationId', $compilationId)
                    ->update(['compilationId' => null]);
            }

            if ($request->ajax()) {
                return Response::json(array('status'=>'success', 'messages' => 'Xoá thành công', 'compilationId' => $compilationId));
            }

            return Redirect::back()->with('flash_notice', 'Xoá thành công');
        }
    }

}