<?php

namespace App\DataTables\Admin;

use App\Order;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Str;

class OrderDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('tanggal', function ($q) {
                return $q->created_at->isoFormat('D MMM Y');
            })
            ->addColumn('produk', function ($q) {
                return view('admin.order.datatables.order-detail', ['order_details' => $q->orderDetails]);
            })
            ->addColumn('total', function ($q) {
                return rupiah_format($q->subtotal + $q->shipping->cost);
            })
            ->addColumn('kurir', fn ($q) => Str::upper($q->shipping->code))
            ->addColumn('action', 'admin.order.datatables.action')
            ->rawColumns(['produk', 'action', 'kurir']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Order $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Order $model)
    {
        return $model->newQuery()
            ->with(['orderDetails', 'orderStatus', 'shipping', 'payment'])
            ->when(request()->has('type'), function ($q) {
                $q->whereHas('orderStatus', function ($q) {
                    $q->where('code', request()->get('type'));
                });
            })->latest();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->languageSearchPlaceholder('Cari Invoice')
            ->setTableId('order-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->buttons(
                Button::make('print')->addClass('btn btn-warning'),
                Button::make('excel')->addClass('btn btn-light'),
                Button::make('csv')->addClass('btn btn-light'),
                Button::make('pdf')->addClass('btn btn-light'),
                Button::make('reset'),
            );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id')->hidden(),
            Column::computed('tanggal'),
            Column::make('invoice')->orderable(false),
            Column::computed('produk'),
            Column::computed('total'),
            Column::computed('status')->data('order_status.status_admin'),
            Column::computed('kurir'),
            Column::computed('action', 'Aksi')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Order_' . date('YmdHis');
    }
}
