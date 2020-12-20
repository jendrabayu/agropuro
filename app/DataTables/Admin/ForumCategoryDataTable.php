<?php

namespace App\DataTables\Admin;

use App\ForumCategory;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ForumCategoryDataTable extends DataTable
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
            ->addColumn('action', 'admin.forum-category.action')
            ->addColumn('created_at', fn ($forumCategory) => $forumCategory->created_at->isoFormat('D MMM Y H:mm'))
            ->addColumn('updated_at', fn ($forumCategory) => $forumCategory->updated_at->isoFormat('D MMM Y H:mm'))
            ->rawColumns(['created_at', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \ForumCategory $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ForumCategory $model)
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
            ->setTableId('forum-category-table')
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
            Column::computed('DT_RowIndex', '#'),
            Column::computed('name', 'Nama')->orderable(true),
            Column::make('created_at')->orderable(false),
            Column::make('updated_at')->orderable(false),
            Column::computed('action', 'Aksi')
                ->exportable(false)
                ->printable(false)
                ->width(60)
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
        return 'ForumCategory_' . date('YmdHis');
    }
}
