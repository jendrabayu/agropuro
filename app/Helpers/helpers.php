
<?php

use App\Address;
use App\Cart;
use App\OrderStatus;
use App\Product;
use Illuminate\Http\Request as FRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * add active class for active route
 * @param string|array $route
 * @return string
 */
function set_active($route)
{

    if (is_array($route)) {
        return in_array(Request::path(), $route) ? 'active' : '';
    }
    return Request::path() == $route ? 'active' : '';
}

/**
 * set name of user words and adding greetings in prefix
 * @see https://medium.com/@feryxz/trick-laravel-change-set-locale-and-timezone-to-indonesia-in-framework-laravel-3355ac53053
 * @param string $name
 * @return string   
 */
function set_name_of_user($name)
{
    $greetings = "";
    $time = date("H");
    $timezone = date("e");
    if ($time < "12") {
        $greetings = "Pagi, ";
    } else if ($time >= "12" && $time < "17") {
        $greetings = "Siang, ";
    } else if ($time >= "17" && $time < "19") {
        $greetings = "Sore, ";
    } else if ($time >= "19") {
        $greetings = "Malam, ";
    }
    return $greetings . '' . Str::title(Str::words($name, 3, ''));
}


function image_upload($request, $name, $path)
{
    if ($request->hasFile($name)) {
        $imageName = uniqid() . time() . '.' . $request->file($name)->getClientOriginalExtension();
        $request->file($name)->storeAs('public', $path . '' . $imageName);
        return $path . '' . $imageName;
    }
    return false;
}


function rupiah_format($money)
{
    if (is_integer($money)) {
        return 'Rp. ' . number_format($money, 0, ',', '.');
    }
    return false;
}

function total_product_in_cart()
{
    if (Auth::check()) {
        return Cart::where('user_id', Auth::user()->id)->sum('quantity');
    }
    return 0;
}

function total_price_in_cart()
{
    if (Auth::check()) {
        $carts = Cart::where('user_id', Auth::user()->id)->get();
        $total = 0;
        foreach ($carts as $k => $v) {
            $total += $v->quantity * $v->product->harga;
        }
        return rupiah_format($total ? $total : 0);
    }
    return 'Rp. 0';
}

function all_product_with_sales()
{
    return Product::withCount(['orderDetails as sales' => function ($query) {
        $query->select(DB::raw('IFNULL(SUM(quantity), 0)'));
    }]);
}


function get_product_with_sales($where = null, $all = false)
{
    if ($all === true) {
        return Product::withCount(['orderDetails as sales' => function ($query) {
            $query->select(DB::raw('IFNULL(sum(quantity), 0)'))->join('orders', 'order_details.order_id', '=', 'orders.id')->where('orders.order_status_id', 5);
        }]);
    }

    return Product::where($where)->withCount(['orderDetails as sales' => function ($query) {
        $query->select(DB::raw('IFNULL(sum(quantity), 0)'))->join('orders', 'order_details.order_id', '=', 'orders.id')->where('orders.order_status_id', 5);
    }]);
}



function check_main_address_customer()
{
    $address = Address::where([['user_id', '=', auth()->user()->id], ['is_main', '=', 1]])->count();

    if ($address > 0) {
        return true;
    }
    return false;
}


function get_order_status_id($code)
{
    return OrderStatus::where('code', $code)->firstOrFail()->id;
}
