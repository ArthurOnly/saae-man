<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OperationTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('operation_types')->insert([
            'name' => "Desligamento"
        ]);
        DB::table('operation_types')->insert([
            'name' => "Religamento"
        ]);
    }
}
