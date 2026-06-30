<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Seed kategori wisata sesuai PRD.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Pantai',   'icon' => '🏖️',  'description' => 'Destinasi wisata pantai dan bahari nusantara'],
            ['name' => 'Gunung',   'icon' => '🏔️',  'description' => 'Petualangan pendakian dan wisata alam pegunungan'],
            ['name' => 'Sejarah',  'icon' => '🏛️',  'description' => 'Situs bersejarah, candi, dan warisan budaya'],
            ['name' => 'Kuliner',  'icon' => '🍜',  'description' => 'Wisata kuliner dan makanan khas daerah'],
            ['name' => 'Alam',     'icon' => '🌿',  'description' => 'Taman nasional, air terjun, dan wisata alam lainnya'],
            ['name' => 'Kota',     'icon' => '🏙️',  'description' => 'Destinasi wisata perkotaan dan modern'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => Str::slug($category['name'])],
                [
                    'name'        => $category['name'],
                    'slug'        => Str::slug($category['name']),
                    'icon'        => $category['icon'],
                    'description' => $category['description'],
                ]
            );
        }

        $this->command->info('✓ Kategori wisata berhasil dibuat: ' . count($categories) . ' kategori.');
    }
}
