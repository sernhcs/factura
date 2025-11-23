<?php

namespace Database\Seeders;

use  App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories =[
            [
                'name'=>'Electronicos',
                'description'=>'articulos electronicos',
            ],
            [
                'name'=>'ropa',
                'description'=>'articulos ropa',
            ],
            [
                'name'=>'alimento',
                'description'=>'articulos alimento',
            ],
            [
                'name'=>'tecnos',
                'description'=>'articulos tecnos',
            ],
            [
                'name'=>'tubol',
                'description'=>'articulos tubol',
            ],
        ];

        foreach($categories as $category){
            Category::create($category);
        }
    }
}
