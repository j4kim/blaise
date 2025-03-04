<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ClientSeeder::class,
            ServiceCategorySeeder::class,
            ServiceSeeder::class,
            BrandSeeder::class,
            LineSeeder::class,
            ArticleSeeder::class,
            VisitSeeder::class,
            SaleSeeder::class,
            TechnicalSheetSeeder::class,
        ]);
    }
}
