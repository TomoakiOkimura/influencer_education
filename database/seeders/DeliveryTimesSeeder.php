<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Delivery_timesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('grades')->insert([
            [
                'delivery_from' => date('Y-m-d H:i:s'),
            ],
            [
                'delivery_to' => date('Y-m-d H:i:s'),
            ]
            ]);
        
}
}