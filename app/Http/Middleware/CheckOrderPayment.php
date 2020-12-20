<?php

namespace App\Http\Middleware;

use App\Order;
use Closure;

class CheckOrderPayment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $orders = Order::query()->where('order_status_id', get_order_status_id('belum-bayar'));
        if (auth()->user()->role === 2) $orders->where('user_id', auth()->id());
        $orders = $orders->get();

        $orders->each(function ($order) {
            $endDate = $order->created_at->addDays(2);

            if (now() > $endDate) {
                $order->update([
                    'order_status_id' => get_order_status_id('dibatalkan'),
                    'canceled_reason' => 'Dibatalkan otomatis oleh sistem: Melewati batas waktu pembayaran'
                ]);

                $order->orderDetails->each(function ($orderDetail) {
                    $orderDetail->product->increment('stok', $orderDetail->quantity);
                });
            }
        });

        return $next($request);
    }
}
