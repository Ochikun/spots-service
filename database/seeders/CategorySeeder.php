<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['name' => '観光', 'color' => '#ff5722'],
            ['name' => 'グルメ', 'color' => '#ffeb3b'],
            ['name' => 'ホテル', 'color' => '#3f51b5'],
            ['name' => '自然', 'color' => '#4caf50'],
            ['name' => '体験', 'color' => '#e91e63'],
            ['name' => '買い物', 'color' => '#9c27b0'],
            ['name' => 'その他', 'color' => '#9e9e9e'], 
        ]);
    }
}
