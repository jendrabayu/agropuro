<?php

namespace App\DataTables\Admin;

use App\OrderDetail;
use App\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProductDataTable extends DataTable
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
            ->addIndexColumn()
            ->addColumn('harga', fn ($product) =>  rupiah_format($product->harga))
            ->addColumn('gambar', fn ($product) =>  '<img class="img-fluid" width="70" src="' . asset('storage/' . $product->gambar) . '"/>')
            ->addColumn('nama_html', 'admin.product.name-column')
            ->addColumn('action', 'admin.product.action')
            ->rawColumns(['gambar', 'action', 'nama_html']);
    }



    /**
     * Get query source of dataTable.
     *
     * @param \App\App\Admin/Product $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Product $model)
    {
        return $model->newQuery()->with(['category'])->withCount(['orderDetails as sales' => function ($q) {
            $q->select(DB::raw('IFNULL(SUM(quantity), 0)'))
                ->join('orders', 'order_details.order_id', '=', 'orders.id')
                ->where('orders.order_status_id', 5);
        }]);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('product-table')
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
            Column::make('nama')->hidden(),
            Column::computed('DT_RowIndex', '#'),
            Column::make('gambar')->orderable(false)->printable(false),
            Column::computed('nama_html', 'Nama'),
            Column::computed('category', 'Kategori')->data('category.name'),
            Column::make('harga'),
            Column::make('stok'),
            Column::computed('sales', 'Penjualan')->orderable(true),
            Column::make('created_at')->hidden(),
            Column::make('updated_at')->hidden(),
            Column::computed('action')
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
        return 'Product_' . date('YmdHis');
    }
}
