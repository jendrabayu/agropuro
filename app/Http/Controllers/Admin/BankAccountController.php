<?php

namespace App\Http\Controllers\Admin;

use App\BankAccount;
use App\DataTables\Admin\BankAccountDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param \App\DataTables\Admin\BankAccountDataTable $bankAccountDataTable
     * @return \Illuminate\Http\Response
     */
    public function index(BankAccountDataTable $bankAccountDataTable)
    {
        return $bankAccountDataTable->render('admin.bank-account.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_bank' => ['required', 'max:30', 'string'],
            'atas_nama' => ['required', 'max:100', 'string'],
            'no_rekening' => ['required', 'max:30', 'string']
        ]);

        BankAccount::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Menambahkan Rekening Baru'
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\BankAccount $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy(BankAccount $bankAccount)
    {
        $bankAccount->delete();

        return response()->json([
            'success' => true,
            'message' => 'Rekening Berhasil Dihapus'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BankAccount $bankAccount)
    {
        $request->validate([
            'nama_bank' => ['required', 'max:30', 'string'],
            'atas_nama' => ['required', 'max:100', 'string'],
            'no_rekening' => ['required', 'max:30', 'string']
        ]);

        $bankAccount->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data Rekening Berhasil Diperbarui'
        ], 200);
    }
}
