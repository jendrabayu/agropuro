<?php

namespace App\DataTables\Admin;

use App\Category;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Str;

class CategoryDataTable extends DataTable
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
            ->addColumn('aksi', 'admin.category.action')
            ->addColumn('total_produk', fn ($category) => $category->products->count())
            ->addColumn('created_at', fn ($category) => $category->created_at->isoFormat('D MMM Y H:mm'))
            ->addColumn('updated_at', fn ($category) => $category->updated_at->isoFormat('D MMM Y H:mm'))
            ->addColumn('image_html', fn ($category) => '<img class="img-fluid" width="70" src="' . Storage::url($category->image) . '" />')
            ->addColumn('image_path', fn ($category) =>  Storage::url($category->image))
            ->rawColumns(['aksi', 'created_at', 'updated_at', 'image_html', 'image_path', 'total_produk']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\App\Admin/Category $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Category $model)
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
            ->setTableId('category-table')
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
            Column::computed('image_html', 'Gambar')->addClass('align-middle'),
            Column::computed('name', 'Nama')->addClass('align-middle'),
            Column::make('total_produk')->addClass('align-middle'),
            Column::make('created_at')->addClass('align-middle'),
            Column::make('updated_at')->addClass('align-middle'),
            Column::computed('aksi')
                ->exportable(false)
                ->printable(false)
                ->addClass('align-middle'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Category_' . date('YmdHis');
    }
}
