<?php

namespace Database\Seeders;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categories = ['Fashion', 'Alam / Nature', 'Funny Pets', 'Beauty'];
    
        foreach ($categories as $cat) {
            Category::create(['name' => $cat]);
        }
    }
}
