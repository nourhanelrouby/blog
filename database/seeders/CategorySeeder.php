<?php

namespace Database\Seeders;

use App\Models\Category\Category;
use App\Models\Category\CategoryTranslation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'image' => 'electronics.jpg',
                'translations' => [

                    'ar' => [
                        'name' => 'إلكترونيات',
                    ],
                    'en' => [
                        'name' => 'Electronics',
                    ]
                ]
            ],
            [
                'image' => 'fashion.jpg',
                'translations' => [

                    'ar' => [
                        'name' => 'Fashion',
                    ],
                    'en' => [
                        'name' => 'موضة',
                    ]

                ]
            ],
        ];

        foreach ($categories as $category) {
            $category1 = Category::create([
                'image' => $category['image'],
            ]);
            multiLanguageSave($category1, $category['translations']);
        }
    }
}
