<?php

use App\BankAccount;
use Illuminate\Database\Seeder;

class BankAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bankAccounts = [
            ['nama_bank' => 'MANDIRI', 'atas_nama' => 'Agropuro', 'no_rekening'  => '132000 481 974 5'],
            ['nama_bank' => 'Mandiri Syariah', 'atas_nama' => 'Agropuro', 'no_rekening'  => '094 301 6001'],
            ['nama_bank' => 'BNI', 'atas_nama' => 'Agropuro', 'no_rekening'  => '1555 1555 81'],
            ['nama_bank' => 'MUAMALAT', 'atas_nama' => 'Agropuro', 'no_rekening'  => '1010082208'],
            ['nama_bank' => 'BRI', 'atas_nama' => 'Agropuro', 'no_rekening'  => '014 076 5481'],
        ];

        foreach ($bankAccounts as $item) {
            BankAccount::create($item);
        }
    }
}
