<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {

        $records=['Fixes','Bug Report','Feature Request','Improvement'];

        foreach ($records as $data){
            DB::table('categories')->insert([
                'name'=>$data,
            ]);
        }




    }
}
