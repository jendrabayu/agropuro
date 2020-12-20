<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\OrderDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RecapController extends Controller
{
    public function index(OrderDataTable $orderDataTable)
    {
        return  $orderDataTable->render('admin.income.index');
    }
}
