<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NilaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                "mahasiswa_id" => "2041720099",
                "matakuliah_id" => "1",
                "nilai" => "A"

            ], [
                "mahasiswa_id" => "2041720099",
                "matakuliah_id" => "2",
                "nilai" => "A"
            ],
            [
                "mahasiswa_id" => "2041720099",
                "matakuliah_id" => "3",
                "nilai" => "A"
            ],
            [
                "mahasiswa_id" => "2041720099",
                "matakuliah_id" => "4",
                "nilai" => "A"
            ],
        ];

        DB::table('mahasiswa_matakuliah')->insert($data);

    }
}
