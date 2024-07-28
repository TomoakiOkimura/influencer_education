<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use App\Models\Curriculum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurriculumsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    
    {
        Curriculum::factory()->count(10)->create();
        
        
    }
}
