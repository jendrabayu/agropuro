<?php

namespace App\DataTables\Admin;

use App\BankAccount;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Str;

class BankAccountDataTable extends DataTable
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
            ->addColumn('created_at', fn ($bankAccount) => $bankAccount->created_at->isoFormat('D MMM Y H:mm'))
            ->addColumn('updated_at', fn ($bankAccount) => $bankAccount->updated_at->isoFormat('D MMM Y H:mm'))
            ->addColumn('aksi', 'admin.bank-account.action')
            ->rawColumns(['aksi', 'created_at', 'updated_at']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\App\Admin/BankAccount $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(BankAccount $model)
    {
        return $model->newQuery()->latest();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('bankaccount-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1);
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
            Column::make('nama_bank')->addClass('align-middle'),
            Column::make('atas_nama')->addClass('align-middle'),
            Column::make('no_rekening')->addClass('align-middle'),
            Column::make('created_at')->addClass('align-middle'),
            Column::make('updated_at')->addClass('align-middle'),
            Column::computed('aksi')
                ->exportable(false)
                ->printable(false)
                ->addClass('align-middle')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'BankAccount_' . date('YmdHis');
    }
}
