<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Bank;
use Str;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banks = [
            [
                'id' => Str::uuid(),
                'bank_name' => 'Bank Mandiri',
                'bank_code' => 'MANDIRI',
            ],
            [
                'id' => Str::uuid(),
                'bank_name' => 'Bank BCA',
                'bank_code' => 'BCA',
            ],
            [
                'id' => Str::uuid(),
                'bank_name' => 'Bank BNI',
                'bank_code' => 'BNI',
            ],
            [
                'id' => Str::uuid(),
                'bank_name' => 'Bank BRI',
                'bank_code' => 'BRI',
            ],
            [
                'id' => Str::uuid(),
                'bank_name' => 'Bank CIMB Niaga',
                'bank_code' => 'CIMB',
            ],
            [
                'id' => Str::uuid(),
                'bank_name' => 'Bank Danamon',
                'bank_code' => 'DANAMON',
            ],
            [
                'id' => Str::uuid(),
                'bank_name' => 'Bank Panin',
                'bank_code' => 'PANIN',
            ],
            [
                'id' => Str::uuid(),
                'bank_name' => 'Bank Permata',
                'bank_code' => 'PERMATA',
            ],
            [
                'id' => Str::uuid(),
                'bank_name' => 'Bank UOB',
                'bank_code' => 'UOB',
            ],
            [
                'id' => Str::uuid(),
                'bank_name' => 'Bank OCBC NISP',
                'bank_code' => 'OCBC',
            ],
            [
                'id' => Str::uuid(),
                'bank_name' => 'Bank Mega',
                'bank_code' => 'MEGA',
            ],
            [
                'id' => Str::uuid(),
                'bank_name' => 'Bank Maybank',
                'bank_code' => 'MAYBANK',
            ],
            [
                'id' => Str::uuid(),
                'bank_name' => 'Bank HSBC',
                'bank_code' => 'HSBC',
            ],
            [
                'id' => Str::uuid(),
                'bank_name' => 'Bank Commonwealth',
                'bank_code' => 'COMMONWEALTH',
            ],
            [
                'id' => Str::uuid(),
                'bank_name' => 'Bank DBS',
                'bank_code' => 'DBS',
            ],
            [
                'id' => Str::uuid(),
                'bank_name' => 'Bank OCBC',
                'bank_code' => 'OCBC',
            ],
            [
                'id' => Str::uuid(),
                'bank_name' => 'Bank BTPN',
                'bank_code' => 'BTPN',
            ],
            [
                'id' => Str::uuid(),
                'bank_name' => 'Bank BTN',
                'bank_code' => 'BTN',
            ],
            [
                'id' => Str::uuid(),
                'bank_name' => 'Bank BJB',
                'bank_code' => 'BJB',
            ],
        ];
        Bank::insert($banks);
    }
}
