<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\LatestOrderDataTable;
use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(LatestOrderDataTable $latestOrderDataTable)
    {
        return $latestOrderDataTable->render(
            'admin.dashboard',
            [
                'belumBayar' => Order::where('order_status_id', get_order_status_id('belum-bayar'))->count(),
                'perluDicek' => Order::where('order_status_id', get_order_status_id('perlu-dicek'))->count(),
                'perluDikirim' => Order::where('order_status_id', get_order_status_id('perlu-dikirim'))->count(),
                'dikirim' => Order::where('order_status_id', get_order_status_id('dikirim'))->count(),
                'orders' => Order::latest()->take(10)->get()
            ]
        );
    }
}
