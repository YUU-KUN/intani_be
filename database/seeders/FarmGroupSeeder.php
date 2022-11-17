<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FarmGroup;
use Str;

class FarmGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public function run()
    {
        $farm_group = [
            [
                'id' => Str::uuid(),
                'name' => 'Mekar Tani',
                'photo' => NULL,
            ],
            [
                'id' => Str::uuid(),
                'name' => 'BIO MEDIA',
                'photo' => NULL,
            ],
            [
                'id' => Str::uuid(),
                'name' => 'KURNIA BAROKAH',
                'photo' => NULL,
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Mekar Bakti',
                'photo' => NULL,
            ],
            [
                'id' => Str::uuid(),
                'name' => 'PAMOYANAN LESTARI',
                'photo' => NULL,
            ],
            [
                'id' => Str::uuid(),
                'name' => 'MOTEKAR',
                'photo' => NULL,
            ],
            [
                'id' => Str::uuid(),
                'name' => 'QIWARI',
                'photo' => NULL,
            ],
            [
                'id' => Str::uuid(),
                'name' => 'KERTARAHARJA',
                'photo' => NULL,
            ],
            [
                'id' => Str::uuid(),
                'name' => 'MEKAR HARUM',
                'photo' => NULL,
            ],
            [
                'id' => Str::uuid(),
                'name' => 'SAUYUNAN',
                'photo' => NULL,
            ],
            [
                'id' => Str::uuid(),
                'name' => 'KARAMAT BERDIKARI',
                'photo' => NULL,
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Sauyunan',
                'photo' => NULL,
            ],
            [
                'id' => Str::uuid(),
                'name' => 'MEKAR TRESNA',
                'photo' => NULL,
            ],
            [
                'id' => Str::uuid(),
                'name' => 'PUTRA CINTA ASIH',
                'photo' => NULL,
            ],
            [
                'id' => Str::uuid(),
                'name' => 'SAWARGI',
                'photo' => NULL,
            ],
            [
                'id' => Str::uuid(),
                'name' => 'WARGI MANDIRI',
                'photo' => NULL,
            ],
            [
                'id' => Str::uuid(),
                'name' => 'PRIMA MEKAR',
                'photo' => NULL,
            ],
            [
                'id' => Str::uuid(),
                'name' => 'MEKAR BERDIRI',
                'photo' => NULL,
            ],
            [
                'id' => Str::uuid(),
                'name' => 'PUTRA TANI',
                'photo' => NULL,
            ],
        ];
        FarmGroup::insert($farm_group);
    }
}
