<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\OrderDataTable;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('check_order_payment');
    }

    /**
     * Display a listing of the resource.
     * 
     * @param \App\DataTables\Admin\OrderDataTable $orderDataTable
     * @return \Illuminate\View\View
     */
    public function index(OrderDataTable $orderDataTable)
    {
        return $orderDataTable->render('admin.order.index', [
            'order_statuses' => OrderStatus::all()
        ]);
    }

    /**
     *  Display the specified resource.
     * 
     * @param int id
     * @param string $invoice
     * @return \Illuminate\View\View
     */
    public function show($id, $invoice)
    {
        return view('admin.order.show', [
            'order' => Order::findOrFail($id)
        ]);
    }


    /**
     * 
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function orderIsCanceled(Request $request, $id)
    {
        $validated = $this->validate($request, ['canceled_reason' => ['required', 'string', 'max:255']], [], [
            'canceled_reason' => 'alasan pembatalan'
        ]);
        $validated['order_status_id'] = get_order_status_id('dibatalkan');

        $order = Order::whereIn('order_status_id', [
            get_order_status_id('belum-bayar'),
            get_order_status_id('perlu-dicek'),
            get_order_status_id('perlu-dikirim')
        ])->findOrFail($id);

        $order->update($validated);
        $order->orderDetails->each(function ($item) {
            $item->product->increment('stok', $item->quantity);
        });
        return back()->with('info', 'Pesanan Dibatalkan');
    }

    /**
     * 
     * 
     * @param int id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function paymentIsConfirmed($id)
    {
        $order = Order::where('order_status_id', get_order_status_id('perlu-dicek'))->findOrFail($id);
        $order->update(['order_status_id' => get_order_status_id('perlu-dikirim')]);
        $order->payment->update(['confirmed_at' => now()]);
        return back()->with('info', 'Pembayaran Berhasil Dikonfirmasi');
    }

    /**
     * 
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $id
     */
    public function addTrackingCode(Request $request, $id)
    {
        $validated = $this->validate($request, [
            'tracking_code' => ['required', 'string', 'max:255']
        ], [], [
            'tracking_code' => 'nomor resi pengiriman'
        ]);

        $order = Order::where('order_status_id', get_order_status_id('perlu-dikirim'))->findOrFail($id);
        $order->update(['order_status_id' => get_order_status_id('dikirim')]);
        $order->shipping->update($validated);
        return back()->with('info', 'Berhasil Menambahkan Nomor Resi Pengiriman');
    }

    /**
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $id
     */
    public function updateTrackingCode(Request $request, $id)
    {
        $validated = $this->validate($request, [
            'tracking_code' => ['required', 'string', 'max:255']
        ], [], [
            'tracking_code' => 'nomor resi pengiriman'
        ]);

        $order = Order::whereIn('order_status_id', [
            get_order_status_id('dikirim'),
            get_order_status_id('selesai'),
        ])->findOrFail($id);

        $order->shipping->update($validated);
        return back()->with('info', 'Nomor Resi Pengiriman Berhasil Diperbarui');
    }

    /**
     * 
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function orderIsDone($id)
    {
        $order = Order::where('order_status_id', get_order_status_id('dikirim'))->findOrFail($id);
        $order->update(['order_status_id' => get_order_status_id('selesai')]);
        return back()->with('info', 'Pesanan Selesai & Barang Telah Tiba Ditujuan');
    }

    /**
     * 
     * 
     * @return \Illuminate\View\View
     */
    public function recap()
    {
        return view('admin.order.recap');
    }

    /**
     * 
     * 
     * 
     */
    public function recapData(Request $request)
    {
        $filter = $request->filter ? $request->filter : 'daily';
        $startDate = $request->start_date ? $request->start_date : new \DateTime('-1 month');
        $endDate = $request->end_date ? $request->end_date :  new \DateTime('+1 month');
        $dateFormat = 'Y-m-d';

        if (strtotime($startDate) !== false && strtotime($endDate) !== false) {
            $startDate = date_create()->setTimestamp(strtotime($startDate));
            $endDate = date_create()->setTimestamp(strtotime($endDate));
            $betweenDate = $startDate > $endDate
                ? [$endDate->format($dateFormat), $startDate->format($dateFormat)]
                : [$startDate->format($dateFormat), $endDate->format($dateFormat)];
        } else {
            return response()->json(['error' => 'BAD REQUEST'], Response::HTTP_BAD_REQUEST);
        }

        $recaps = DB::table('orders as o')
            ->select(
                DB::raw(($filter === 'daily' || !in_array($filter, ['daily', 'monthly', 'yearly'])  ? 'DAY(o.created_at)' : 'null') . ' date'),
                DB::raw(($filter === 'monthly' || $filter === 'daily' ? 'MONTHNAME(o.created_at)' : 'null') . ' month'),
                DB::raw('YEAR(o.created_at) year'),
                DB::raw('COUNT(o.id) total_order'),
                DB::raw('SUM(od.quantity) products_sold'),
                DB::raw('(SUM(o.subtotal) + SUM(s.cost)) income')
            )
            ->join('order_details as od', 'o.id', '=', 'od.order_id')
            ->join('payments as p', 'o.payment_id', '=', 'p.id')
            ->join('shippings as s', 'o.shipping_id', '=', 's.id')
            ->where('o.order_status_id', 5)
            ->whereBetween('o.created_at', $betweenDate)
            ->groupBy('year');

        if ($filter === 'monthly') {
            $recaps->groupBy(DB::raw('MONTHNAME(o.created_at)'), 'month');
        } else if ($filter === 'yearly') {
            $recaps->groupBy(DB::raw('YEAR(o.created_at)'));
        } else {
            $recaps->groupBy(DB::raw('DAY(o.created_at)'), 'year', 'month', 'date');
        }

        $recaps->orderByDesc('o.created_at');

        $recaps = $recaps->get();

        return response()->json(['recaps' => $recaps], 200);
    }
}
