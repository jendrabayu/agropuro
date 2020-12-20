<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\CustomersDataTable;
use App\Http\Controllers\Controller;
use App\User;

class CustomerController extends Controller
{
    public function __invoke(CustomersDataTable $customersDataTable)
    {
        return $customersDataTable->render('admin.customer', [
            'total_customers' => User::where('role', User::ROLE_USER)->count()
        ]);
    }
}
