<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

use App\Recipe;
use App\Customer;
use App\Order;

class OrderController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $menu = 'order';
        $orders = DB::table('orders')
            ->join('customers', 'orders.customerId', '=', 'customers.id')
            ->join('menus', 'orders.productId', '=', 'menus.id')
            ->select('orders.*', 'customers.name', 'customers.phone', 'customers.address', 'menus.title')
            ->paginate(15);

        return view('orders.list', compact('menu', 'orders'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        $menu = 'order';

        return view('orders.list', compact('menu'));
    }

    public function edit(Request $request, $orderId)
    {
        $order = DB::table('orders')
            ->join('customers', 'orders.customerId', '=', 'customers.id')
            ->where('orders.id', $orderId)
            ->select('orders.*', 'customers.name', 'customers.phone', 'customers.address')
            ->first();

        if ($request->isMethod('post')) {
            $note = Input::get('note');
            $status = Input::get('status');

            $orderOrigin = Order::find($order->id);
            $orderOrigin->adminNote = $note;
            $orderOrigin->status = $status;

            $orderOrigin->save();

            return Redirect::back()->with('flash_notice', 'Cập nhật thành công')->with(compact('order'));
        }

        $menu = 'order';
        return view('orders.edit', compact('menu', 'order'));
    }
}
