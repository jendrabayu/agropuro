<?php

namespace App\Http\Controllers\User;

use App\Cart;
use App\Courier;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Order;
use App\OrderDetail;
use App\OrderStatus;
use App\Payment;
use App\Product;
use App\Shipping;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('check_order_payment');
    }

    /**
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $orders = auth()->user()->orders()->with(['orderStatus']);

        $orders->when($request->has('type'), function ($q) use ($request) {
            $q->whereHas('orderStatus', function ($q) use ($request) {
                $q->where('code', $request->get('type'));
            });
        });

        $orderStatus = OrderStatus::all();
        $orders = $orders->latest()->paginate(5);
        return view('user.order.index', compact('orders', 'orderStatus'));
    }

    /**
     * 
     * @param mixed $invoice
     * @return \Illuminate\View\View
     */
    public function show($id, $invoice)
    {
        $order = auth()->user()->orders()->findOrFail($id);
        return view('user.order.detail', compact('order'));
    }

    /**
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'order' => ['array', 'required'],
            'payment' => ['array', 'required'],
            'shipping' => ['array', 'required'],
        ]);

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_status_id' => get_order_status_id('belum-bayar'),
                'invoice' => Str::upper(date('ydm') . Str::padLeft((int)(Order::latest()->first()->id ?? 0), 5, 0) . Str::random(3)),
                'subtotal' => $request->order['subTotal'],
                'message' => $request->order['message'],
            ]);

            $payment = Payment::create([
                'order_id' => $order->id,
                'bank_account_id' => $request->payment['bank_account_id'],
            ]);

            $shipping = Shipping::create([
                'order_id' => $order->id,
                'address_id' => $request->shipping['address_id'],
                'code' => $request->shipping['code'],
                'service' => $request->shipping['service'],
                'cost' => $request->shipping['cost'],
                'etd' => $request->shipping['etd']
            ]);

            $order->update(['payment_id' => $payment->id, 'shipping_id' =>  $shipping->id]);

            $carts = auth()->user()->carts;

            $carts->each(function ($cart) use ($order) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $cart->product->id,
                    'price' => $cart->product->harga,
                    'quantity' => $cart->quantity
                ]);

                $cart->product()->decrement('stok', $cart->quantity);
                $cart->delete();
            });

            DB::commit();

            return response()->json([
                'data' => $order,
                'href' => route('customer.order.show', [
                    $order->id,
                    $order->invoice,
                    'upload-bukti-transfer' => 'show'
                ])
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }

    /**
     * Change status order to done
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function isDone($id)
    {
        auth()->user()->orders()
            ->where('order_status_id', get_order_status_id('dikirim'))
            ->findOrFail($id)->update(['order_status_id' => get_order_status_id('selesai')]);
        return back()->with('info', 'Pesanan Sudah Selesai');
    }

    /**
     * Store payment proof in storage and change status
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addPaymentProof(Request $request, $id)
    {
        $order = auth()->user()->orders()
            ->where('order_status_id', get_order_status_id('belum-bayar'))->findOrFail($id);

        $validated = $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'bank' => ['required', 'string', 'max:255'],
            'account_number' => ['required', 'string', 'max:255'],
            'payment_proof' => ['nullable', 'mimes:jpeg,jpg,png', 'max:1000']
        ]);

        if ($request->has('payment_proof')) {
            $validated['payment_proof'] = $request->file('payment_proof')->store('images/payment-proof', 'public');
        }

        $order->update(['order_status_id' => get_order_status_id('perlu-dicek')]);
        $order->payment()->update($validated);

        return back()->with('info', 'Menunggu Pembayaran Dikonfirmasi Admin');
    }
}
