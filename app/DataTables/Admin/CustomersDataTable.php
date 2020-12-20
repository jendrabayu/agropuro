<?php

namespace App\DataTables\Admin;

use App\User;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CustomersDataTable extends DataTable
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
            ->addColumn('photo-html', function (User $user) {
                $path = asset('storage/' . $user->photo);
                return '<img class="rounded-circle" width="50" src="' . $path . '"/>';
            })
            ->addColumn('created_at', fn ($forumCategory) => $forumCategory->created_at->isoFormat('D MMM Y'))
            ->addColumn('updated_at', fn ($forumCategory) => $forumCategory->updated_at->isoFormat('D MMM Y'))
            ->rawColumns(['photo-html']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        return $model->where('role', 2)->with(['forums.forumComments'])->withCount([
            'orders as sales' => function ($order) {
                $order->join('order_details', 'order_details.order_id', '=', 'orders.id')
                    ->select(DB::raw('IFNULL(SUM(order_details.quantity), 0)'))->where('orders.order_status_id', 5);
            },
            'forums',

        ])->latest();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('customers-table')
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
            Column::computed('DT_RowIndex', '#')->addClass('align-middle'),
            Column::computed('photo-html', 'Foto')->addClass('align-middle')->orderable(false)->searchable(false)->printable(false),
            Column::make('name')->addClass('align-middle'),
            Column::make('email')->addClass('align-middle'),
            Column::computed('sales', 'Pembelian')->addClass('align-middle'),
            Column::computed('forums_count', 'Forum')->addClass('align-middle'),
            Column::make('created_at')->addClass('align-middle'),

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'customers_' . date('YmdHis');
    }
}
