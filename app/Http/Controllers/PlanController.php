<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;

use App\Recipe;
use App\Menu;
use Carbon\Carbon;
use DateTime;
use App\Compilation;
use Response;

class PlanController extends Controller
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
    public function list(Request $request, $serving='')
    {
        $menu = 'menu';
        $menuItems = Menu::orderBy('updated_at', 'DESC')->paginate(15);

        return view('menus.list', compact('menu', 'menuItems', 'serving'));
    }

    public function updateStatus(Request $request, $menuId, $status)
    {
        $menuItem = Menu::find($menuId);
        if ($menuItem) {
            $menuItem->status = $status;
            $menuItem->save();
        }

        return Redirect::back();
    }

    public function publishMenuDate(Request $request, $menuId, $date)
    {
        $menuItem = Menu::find($menuId);
        if ($menuItem) {
            $menuItem->publishDate = $date;
            $menuItem->save();
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
        $menu = 'menu';

        if ($request->isMethod('post'))
        {
            $menuItem = new Menu();
            $menuItem->title = Input::get('title');
            $menuItem->thumb = Input::get('thumb');
            $menuItem->ingredient = Input::get('ingredient');
            $menuItem->preparation = Input::get('preparation');
            $menuItem->video = Input::get('video');
            $menuItem->price = Input::get('price');
            $menuItem->serving = Input::get('serving');
            $menuItem->status = Input::get('status');

            $date = new Carbon(Input::get('publishDate'));
            $date->format('Y-m-d H:i:s');
            $menuItem->publishDate = $date;

            $menuItem->save();
            if ($menuItem->id) {
                return Redirect::back()->with('flash_notice', 'Tạo bài viết thành công!');
            } else {
                //save fail
                return Redirect::back()->with('flash_error', 'Tạo bài viết lỗi!');
            }
        }

        return view('menus.add', compact('menu'));
    }

    public function edit(Request $request, $menuId)
    {
        $menu = 'menu';
        $menuItem = Menu::find($menuId);

        if ($request->isMethod('post'))
        {
            $menuItem->title = Input::get('title');
            $menuItem->thumb = Input::get('thumb');
            $menuItem->ingredient = Input::get('ingredient');
            $menuItem->preparation = Input::get('preparation');
            $menuItem->video = Input::get('video');
            $menuItem->price = Input::get('price');
            $menuItem->serving = Input::get('serving');
            $menuItem->status = Input::get('status');

            $date = new Carbon(Input::get('publishDate'));
            $date->format('Y-m-d H:i:s');
            $menuItem->publishDate = $date;

            $menuItem->save();

            return Redirect::back()->with('flash_notice', 'Cập nhật thành công')->with(compact('menuItem'));
        }

        return view('menus.edit', compact('menu', 'menuItem'));
    }

    public function delete(Request $request, $menuId)
    {
        if ($request->isMethod('post'))
        {
            $menu = Menu::find($menuId);
            if ($menu) {
                $menu->delete();
            }

            if ($request->ajax()) {
                return Response::json(array('status'=>'success', 'messages' => 'Xoá thành công', 'menuId' => $menuId));
            }

            return Redirect::back()->with('flash_notice', 'Xoá thành công');
        }
    }
}
