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
    public function show($invoice)
    {
        $order = auth()->user()->orders()->where('invoice', $invoice)->firstOrFail();
        return view('user.order.detail', compact('order'));
    }


    public function update(Request $request,  $id)
    {
        $order = Order::findOrFail($id);

        if ($request->only('bukti_transfer')) {
            $request->validate(['bukti_transfer' => ['required', 'max:1000', 'image']]);
            $buktiTransfer = image_upload($request, 'bukti_transfer', 'images/bukti_transfer/');
            $order->update([
                'order_status_id' => self::types['sedang-dicek'],
                'bukti_transfer' => $buktiTransfer,
            ]);
            return redirect()->route('customer.order.index', ['type' => 'perlu-dicek']);
        }
    }

    public function storePaymentProof(Request $request, $invoice)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'bank' => 'required|string',
            'account_number' => 'required|string',
            'payment_proof' => 'nullable|image|max:1000'
        ]);

        $order = Order::where('invoice', $invoice)->firstOrFail();

        if ($request->hasFile('payment_proof')) {
            $data['payment_proof'] = $request->file('payment_proof')->store('images/bukti_transfer', 'public');
        }

        $order->update(['order_status_id' => 2]);
        $order->payment()->update($data);

        return back()->with('info', 'Menunggu Pembayaran Dikonfirmasi');
    }


    public function store(Request $request)
    {
        $request->validate([
            'order' => 'array|required',
            'payment' => 'array|required',
            'shipping' => 'array|required',
        ]);

        $order = Order::create([
            'user_id' => auth()->id(),
            'order_status_id' => 1,
            'invoice' => $this->generateInvoice(),
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

        $order->payment_id = $payment->id;
        $order->shipping_id = $shipping->id;
        $order->save();

        $carts = Cart::where('user_id', get_user_id())->get();

        foreach ($carts as $cart) {
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $cart->product->id,
                'price' => $cart->product->harga,
                'quantity' => $cart->quantity
            ]);

            Product::where('id', $cart->product->id)->decrement('stok', $cart->quantity);
            Cart::where('id', $cart->id)->delete();
        }

        return response()->json([
            'data' => $order,
            'href' => route('customer.order.detail', [
                'order' => $order->invoice,
                'upload-bukti-transfer' => 'show'
            ])
        ]);
    }

    private function generateInvoice()
    {
        return (intval(date('ydmhs')) + intval(date('dhs'))) . Str::upper(Str::random(3)) . auth()->id();
    }
}
